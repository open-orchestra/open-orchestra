<?php

namespace OpenOrchestra\FunctionalTests\ApiBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use OpenOrchestra\FunctionalTests\Utils\AbstractAuthenticatedTest;
use OpenOrchestra\ModelInterface\Model\NodeInterface;
use OpenOrchestra\ModelInterface\Repository\BlockRepositoryInterface;
use OpenOrchestra\ModelInterface\Repository\NodeRepositoryInterface;
use OpenOrchestra\ModelInterface\Repository\StatusRepositoryInterface;

/**
 * Class NodeControllerTest
 *
 * @group apiFunctional
 */
class NodeControllerTest extends AbstractAuthenticatedTest
{
    /**
     * @var StatusRepositoryInterface
     */
    protected $statusRepository;

    /**
     * @var NodeRepositoryInterface
     */
    protected $nodeRepository;

    /** @var BlockRepositoryInterface */
    protected $blockRepository;

    /**
     * Set up the test
     */
    public function setUp()
    {
        parent::setUp();
        $this->nodeRepository = static::$kernel->getContainer()->get('open_orchestra_model.repository.node');
        $this->statusRepository = static::$kernel->getContainer()->get('open_orchestra_model.repository.status');
        $this->blockRepository = static::$kernel->getContainer()->get('open_orchestra_model.repository.block');
    }

    /**
     * Reset removing node after test
     */
    public function tearDown()
    {
        $nodes = $this->nodeRepository->findByNodeAndSite('fixture_page_contact', '2');
        $this->undeleteNodes($nodes);
        $this->republishNodes($nodes);
        static::$kernel->getContainer()->get('object_manager')->flush();
        parent::tearDown();
    }

    /**
     * Test delete action
     */
    public function testDeleteAction()
    {
        $this->markTestSkipped('To reactivate when API roles will be implemented');

        $node = $this->nodeRepository->findOnePublished('fixture_page_contact','fr','2');
        $node->getStatus()->setPublishedState(false);
        static::$kernel->getContainer()->get('object_manager')->flush();

        $nbNode = count($this->nodeRepository->findLastVersionByType('2'));
        $this->client->request('DELETE', '/api/node/fixture_page_contact/delete');
        $nodesDelete = $this->nodeRepository->findLastVersionByType('2');

        $this->assertCount($nbNode - 1, $nodesDelete);
    }

    /**
     * @param array $nodes
     */
    protected function undeleteNodes($nodes)
    {
        foreach ($nodes as $node) {
            $node->setDeleted(false);
        }
    }

    /**
     * @param array $nodes
     */
    protected function republishNodes($nodes)
    {
        foreach ($nodes as $node) {
            $node->getStatus()->setPublishedState(true);
        }
    }

    /**
     * Test node new version and references
     */
    public function testNewVersioneNode()
    {
        $this->markTestSkipped('To reactivate when API roles will be implemented');

        $node = $this->nodeRepository
            ->findInLastVersion('fixture_page_community', 'fr', '2');
        $this->client->request('POST', '/api/node/fixture_page_community/new-version?language=fr');

        $nodeLastVersion = $this->nodeRepository
            ->findInLastVersion('fixture_page_community', 'fr', '2');

        $this->assertSame($node->getVersion()+1, $nodeLastVersion->getVersion());
    }

    /**
     * Test creation of new language for a node
     */
    public function testCreateNewLanguageNode()
    {
        $this->markTestSkipped('To reactivate when API roles will be implemented');

        $this->client->request('GET', '/api/node/root/show-or-create', array('language' => 'de'));

        $node = $this->nodeRepository
            ->findInLastVersion('root', 'de', '2');

        $this->assertInstanceOf('OpenOrchestra\ModelInterface\Model\NodeInterface', $node);
        $this->assertSame(1, $node->getVersion());
        $this->assertSame('de', $node->getLanguage());
        static::$kernel->getContainer()->get('object_manager')->remove($node);
        static::$kernel->getContainer()->get('object_manager')->flush();
    }

    /**
     * @param NodeInterface $node
     *
     * @return int
     */
    public function countAreaRef(NodeInterface $node)
    {
        $areaRef = 0;
        foreach ($node->getBlocks() as $block) {
            $areaRef = $areaRef + count($block->getAreas());
        }

        return $areaRef;
    }

    /**
     * @param string $name
     * @param int    $publishedVersion
     *
     * @dataProvider provideStatusNameAndPublishedVersion
     */
    public function testChangeNodeStatus($name, $publishedVersion)
    {
        $this->markTestSkipped('To reactivate when change status embed is fixed');

        $node = $this->nodeRepository->findInLastVersion('root', 'fr', '2');
        $newStatus = $this->statusRepository->findOneByName($name);
        $requestContent = json_encode(array(
            'id' => $node->getId(),
            'status' => array(
                'id' => $newStatus->getId()
            )
        ));
        $this->client->request(
            'PUT',
            '/api/node/update-status',
            array(),
            array(),
            array(),
            $requestContent
        );

        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
        $newNode = $this->nodeRepository->findOnePublished('root', 'fr', '2');
        $this->assertEquals($publishedVersion, $newNode->getVersion());
    }

    /**
     * @return array
     */
    public function provideStatusNameAndPublishedVersion()
    {
        return array(
            array('pending', 1),
            array('published', 2),
            array('draft', 1),
        );
    }

    /**
     * Test update not granted
     */
    public function testUpdateNotGranted()
    {
        $this->username = 'userNoAccess';
        $this->password = 'userNoAccess';
        $this->logIn();

        $node = $this->nodeRepository->findInLastVersion('root', 'fr', '2');
        $requestContent = json_encode(array(
            'id' => $node->getId()
        ));
        $this->client->request(
            'PUT',
            '/api/node/update-status',
            array(),
            array(),
            array(),
            $requestContent
        );

        $this->assertSame(403, $this->client->getResponse()->getStatusCode());
    }

    /**
     * Test update block position
     */
    public function testUpdateBlockPosition()
    {
        $node = $this->nodeRepository->findInLastVersion('root', 'fr', '2');
        $block0 = $node->getArea('main')->getBlocks()[0];
        $block1 = $node->getArea('main')->getBlocks()[1];

        $blocksMainJson = array();
        $blocksMainJson[] = array('id' => $block1->getId());
        $blocksMainJson[] = array('id' => $block0->getId());

        $requestContent = json_encode(array(
            'areas' => array(
                'main' => array(
                    'blocks' => $blocksMainJson
                )
            )
        ));

        $this->client->request(
            'PUT',
            "/api/node/update-block-position/".$node->getSiteId()."/".$node->getNodeId()."/".$node->getVersion()."/".$node->getLanguage(),
            array(),
            array(),
            array(),
            $requestContent
        );

        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
        $dm = static::$kernel->getContainer()->get('object_manager');

        $node = $this->nodeRepository->findInLastVersion('root', 'fr', '2');
        $blocksMain = $node->getArea('main')->getBlocks();
        $this->assertCount(2, $blocksMain);
        $this->assertSame($node->getArea('main')->getBlocks()[0], $block1);
        $this->assertSame($node->getArea('main')->getBlocks()[1], $block0);

        $node->getArea('main')->setBlocks(new ArrayCollection(array($block0, $block1)));
        $dm->persist($node);
        $dm->flush();
    }

    /**
     * Test update block position not granted
     */
    public function testUpdateBlockPositionNotGranted()
    {
        $this->username = 'userNoAccess';
        $this->password = 'userNoAccess';
        $this->logIn();

        $node = $this->nodeRepository->findInLastVersion('root', 'fr', '2');

        $this->client->request(
            'PUT',
            "/api/node/update-block-position/".$node->getSiteId()."/".$node->getNodeId()."/".$node->getVersion()."/".$node->getLanguage()
        );

        $this->assertSame(403, $this->client->getResponse()->getStatusCode());
    }

    /**
     * Test delete block not granted
     */
    public function testDeleteBlockInAreaNotGranted()
    {
        $this->username = 'userNoAccess';
        $this->password = 'userNoAccess';
        $this->logIn();

        $node = $this->nodeRepository->findInLastVersion('root', 'fr', '2');
        $block = $node->getArea('main')->getBlocks()[0];

        $this->client->request(
            'DELETE',
            "/api/node/delete-block/".$node->getNodeId()."/".$node->getSiteId()."/".$node->getLanguage()."/".$node->getVersion()."/main/".$block->getId()
        );
        $this->assertSame(403, $this->client->getResponse()->getStatusCode());
    }

    /**
     * Test add block in area action
     */
    public function testAddBlockInAreaAction()
    {
        $node = $this->nodeRepository->findInLastVersion('root', 'fr', '2');
        $blocks = $this->blockRepository->findTransverseBlock('tiny_mce_wysiwyg', '2', 'fr');
        $block = $blocks[0];

        $this->client->request(
            'PUT',
            "/api/node/add-block-in-area/".$node->getNodeId()."/".$node->getLanguage()."/".$node->getVersion()."/".$block->getId()."/main/1"
        );

        $dm = static::$kernel->getContainer()->get('object_manager');
        $dm->detach($node);
        $dm->clear();
        $node = $this->nodeRepository->findInLastVersion('root', 'fr', '2');
        $mainAreaBlocks = $node->getArea('main')->getBlocks();
        $addedBlock = $mainAreaBlocks[1];

        $this->assertSame($block->getId(), $addedBlock->getId());
    }

    /**
     * Test delete block
     */
    public function testDeleteBlockInArea()
    {
        $node = $this->nodeRepository->findInLastVersion('root', 'fr', '2');
        $block = $node->getArea('main')->getBlocks()[0];

        $this->client->request(
            'DELETE',
            "/api/node/delete-block/".$node->getNodeId()."/".$node->getSiteId()."/".$node->getLanguage()."/".$node->getVersion()."/main/".$block->getId()
        );
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
        $this->assertNull($this->blockRepository->findById($block->getId()));

        $dm = static::$kernel->getContainer()->get('object_manager');
        $dm->detach($node);
        $dm->detach($block);

        $node = $this->nodeRepository->findInLastVersion('root', 'fr', '2');
        $blocks = $node->getArea('main')->getBlocks();
        $this->assertCount(1, $blocks);
        $node->getArea('main')->addBlock($block);
        $dm->persist($node);
        $dm->persist($block);

        $dm->flush();
    }

    /**
     * Test delete transverse block
     */
    public function testDeleteTransverseBlockInArea()
    {

        $node = $this->nodeRepository->findInLastVersion('root', 'fr', '2');
        $block = $node->getArea('main')->getBlocks()[0];

        $this->client->request(
            'DELETE',
            "/api/node/delete-block/".$node->getNodeId()."/".$node->getSiteId()."/".$node->getLanguage()."/".$node->getVersion()."/main/".$block->getId()
        );
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals($block, $this->blockRepository->findById($block->getId()));

        $dm = static::$kernel->getContainer()->get('object_manager');
        $dm->detach($node);
        $dm->detach($block);

        $node = $this->nodeRepository->findInLastVersion('root', 'fr', '2');
        $blocks = $node->getArea('main')->getBlocks();
        $this->assertCount(1, $blocks);

        $node->getArea('main')->addBlock($block);
        $dm->persist($block);
        $dm->persist($node);
        $dm->flush();
    }
}
