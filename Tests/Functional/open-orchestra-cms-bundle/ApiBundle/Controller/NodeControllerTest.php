<?php

namespace OpenOrchestra\ApiBundle\Tests\Functional\Controller;

use OpenOrchestra\ModelInterface\Model\NodeInterface;
use OpenOrchestra\ModelInterface\Repository\StatusRepositoryInterface;

/**
 * Class NodeControllerTest
 *
 * @group apiFunctional
 */
class NodeControllerTest extends AbstractControllerTest
{
    /**
     * @var StatusRepositoryInterface
     */
    protected $statusRepository;

    /**
     * Set up the test
     */
    public function setUp()
    {
        $this->client = static::createClient();

        $crawler = $this->client->request('GET', '/login');

        $form = $crawler->selectButton('Log in')->form();
        $form['_username'] = $this->username;
        $form['_password'] = $this->password;

        $this->client->submit($form);

        $this->nodeRepository = static::$kernel->getContainer()->get('open_orchestra_model.repository.node');
        $this->statusRepository = static::$kernel->getContainer()->get('open_orchestra_model.repository.status');
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
        $node = $this->nodeRepository->findOneCurrentlyPublished('fixture_page_contact','fr','2');
        $node->getStatus()->setPublished(false);
        static::$kernel->getContainer()->get('object_manager')->flush();

        $crawler = $this->client->request('GET', '/admin/');
        $nbLink = $crawler->filter('a')->count();

        $this->client->request('DELETE', '/api/node/fixture_page_contact/delete');

        $crawler = $this->client->request('GET', '/admin/');

        $this->assertCount($nbLink - 2, $crawler->filter('a'));
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
            $node->getStatus()->setPublished(true);
        }
    }

    /**
     * Test node duplicate and references
     */
    public function testDuplicateNode()
    {
        $node = $this->nodeRepository
            ->findInLastVersion('fixture_page_community', 'fr', '2');
        $nodeTransverse = $this->nodeRepository
            ->findInLastVersion(NodeInterface::TRANSVERSE_NODE_ID, 'fr', '2');

        $this->client->request('POST', '/api/node/fixture_page_community/duplicate?language=fr');

        $nodeLastVersion = $this->nodeRepository
            ->findInLastVersion('fixture_page_community', 'fr', '2');

        $nodeRepository = static::$kernel->getContainer()->get('open_orchestra_model.repository.node');
        $nodeTransverseAfter = $nodeRepository
            ->findInLastVersion(NodeInterface::TRANSVERSE_NODE_ID, 'fr', '2');

        $this->assertSame($node->getVersion()+1, $nodeLastVersion->getVersion());
        $this->assertGreaterThanOrEqual($this->countAreaRef($nodeTransverse), $this->countAreaRef($nodeTransverseAfter));
    }

    /**
     * Test creation of new language for a node
     */
    public function testCreateNewLanguageNode()
    {
        $node = $this->nodeRepository
            ->findInLastVersion('root', 'en', '2');
        if (!is_null($node)) {
            $this->markTestIncomplete('The node has already been created');
        }

        $nodeTransverse = $this->nodeRepository
            ->findInLastVersion(NodeInterface::TRANSVERSE_NODE_ID, 'en', '2');
        $countAreaRef = $this->countAreaRef($nodeTransverse);

        $this->assertSame(null, $node);
        $this->assertSame(5, $countAreaRef);

        $this->client->request('GET', '/api/node/root/show-or-create', array('language' => 'en'));


        $nodeRepository = static::$kernel->getContainer()->get('open_orchestra_model.repository.node');
        $nodeTransverseAfter = $nodeRepository
            ->findInLastVersion(NodeInterface::TRANSVERSE_NODE_ID, 'en', '2');

        $this->assertGreaterThan($countAreaRef, $this->countAreaRef($nodeTransverseAfter));
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
        $node = $this->nodeRepository->findInLastVersion('root', 'fr', '2');
        $newStatus = $this->statusRepository->findOneByName($name);
        $newStatusId = $newStatus->getId();

        $this->client->request(
            'POST',
            '/api/node/' . $node->getId() . '/update',
            array(),
            array(),
            array(),
            json_encode(array('status_id' => $newStatusId))
        );

        $this->assertSame(200, $this->client->getResponse()->getStatusCode());

        $newNode = $this->nodeRepository->findOneCurrentlyPublished('root', 'fr', '2');
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
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('Log in')->form();
        $form['_username'] = 'userNoAccess';
        $form['_password'] = 'userNoAccess';
        $this->client->submit($form);
        $node = $this->nodeRepository->findInLastVersion('root', 'fr', '2');
        $this->client->request(
            'POST',
            '/api/node/' . $node->getId() . '/update',
            array(),
            array(),
            array(),
            json_encode(array('status_id' => 'fakeStatus'))
        );
        $this->assertSame(403, $this->client->getResponse()->getStatusCode());
    }
}
