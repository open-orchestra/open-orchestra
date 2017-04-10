<?php

namespace OpenOrchestra\FunctionalTests\ModelBundle\Repository;

use OpenOrchestra\BaseBundle\Tests\AbstractTest\AbstractKernelTestCase;
use OpenOrchestra\ModelInterface\Model\NodeInterface;
use OpenOrchestra\ModelBundle\Repository\NodeRepository;
use OpenOrchestra\ModelInterface\NodeEvents;
use OpenOrchestra\Pagination\Configuration\PaginateFinderConfiguration;

/**
 * Class NodeRepositoryTest
 *
 * @group integrationTest
 */
class NodeRepositoryTest extends AbstractKernelTestCase
{
    /**
     * @var NodeRepository
     */
    protected $repository;
    protected $userRepository;

    /**
     * Set up test
     */
    protected function setUp()
    {
        parent::setUp();

        static::bootKernel();
        $this->repository = static::$kernel->getContainer()->get('open_orchestra_model.repository.node');
        $this->userRepository = static::$kernel->getContainer()->get('open_orchestra_user.repository.user');
    }

    /**
     * @param string $language
     * @param int    $version
     * @param string $siteId
     *
     * @dataProvider provideLanguageLastVersionAndSiteId
     */
    public function testFindOnePublished($language, $version, $siteId)
    {
        $node = $this->repository->findOnePublished(NodeInterface::ROOT_NODE_ID, $language, $siteId);

        $this->assertSameNode($language, $version, $siteId, $node);
    }

    /**
     * @return array
     */
    public function provideLanguageLastVersionAndSiteId()
    {
        return array(
            array('en', '1', '2'),
            array('fr', '1', '2'),
        );
    }

    /**
     * @param string $language
     * @param int    $version
     * @param string $siteId
     *
     * @dataProvider provideLanguageLastVersionAndSiteIdNotPublished
     */
    public function testFindVersionNotDeleted($language, $version, $siteId)
    {
        $node = $this->repository->findVersionNotDeleted(NodeInterface::ROOT_NODE_ID, $language, $siteId, $version);

        $this->assertSame($node->getNodeId(), NodeInterface::ROOT_NODE_ID);
        $this->assertSame($node->getVersion(), $version);
    }

    /**
     * @return array
     */
    public function provideLanguageLastVersionAndSiteIdNotPublished()
    {
        return array(
            array('fr', '2', '2', 3),
            array('fr', '1', '2', 3),
        );
    }

    /**
     * @param string $nodeId
     * @param string $language
     * @param string $siteId
     * @param int    $versionExpected
     *
     * @dataProvider provideNodeLanguageLastVersionAndSiteId
     */
    public function testFindInLastVersion($nodeId, $language, $siteId, $versionExpected)
    {
        $node = $this->repository->findInLastVersion($nodeId, $language, $siteId);

        $this->assertSameNode($language, $versionExpected, $siteId, $node, $nodeId);
    }

    /**
     * @return array
     */
    public function provideNodeLanguageLastVersionAndSiteId()
    {
        return array(
            array('fixture_auto_unpublish', 'fr', '2', '1'),
            array('fixture_page_news', 'fr', '2', '1'),
        );
    }

    /**
     * @param int    $countVersions
     * @param string $language
     * @param string $siteId
     *
     * @dataProvider provideLanguageAndVersionListAndSiteId
     */
    public function testFindNotDeletedSortByUpdatedAt($countVersions, $language, $siteId)
    {
        $nodes = $this->repository->findNotDeletedSortByUpdatedAt(NodeInterface::ROOT_NODE_ID, $language, $siteId);

        $this->assertCount($countVersions, $nodes);
        foreach ($nodes as $node) {
            $this->assertSameNode($language, $node->getVersion(), $siteId, $node);
        }
        if (count($nodes) > 1) {
            for ($i = 1; $i < count($nodes); $i++) {
                $this->assertGreaterThan($nodes[$i]->getVersion(), $nodes[$i-1]->getVersion());
            }
        }
    }

    /**
     * @param int    $countVersions
     * @param string $language
     * @param string $siteId
     *
     * @dataProvider provideLanguageAndVersionListAndSiteId
     */
    public function testCountNotDeletedVersions($countVersions, $language, $siteId)
    {
        $countNodes = $this->repository->countNotDeletedVersions(NodeInterface::ROOT_NODE_ID, $language, $siteId);

        $this->assertSame($countVersions, $countNodes);
    }

    /**
     * @return array
     */
    public function provideLanguageAndVersionListAndSiteId()
    {
        return array(
            array(1, 'en', '2'),
            array(3, 'fr', '2'),
        );
    }

    /**
     * @param string $nodeId
     * @param string $siteId
     * @param int    $count
     *
     * @dataProvider provideNodeSiteAndCount
     */
    public function testFindByNodeAndSite($nodeId, $siteId, $count)
    {
        $this->assertCount($count, $this->repository->findByNodeAndSite($nodeId, $siteId));
    }

    /**
     * @return array
     */
    public function provideNodeSiteAndCount()
    {
        return array(
            array(NodeInterface::ROOT_NODE_ID, '2', 5),
            array('fixture_page_what_is_orchestra', '2', 0),
        );
    }

    /**
     * @param string $parentId
     * @param string $siteId
     * @param int    $count
     *
     * @dataProvider provideParentIdSiteIdAndCount
     */
    public function testFindByParent($parentId, $siteId, $count)
    {
        $nodes = $this->repository->findByParent($parentId, $siteId);

        $this->assertGreaterThanOrEqual($count, count($nodes));
    }

    /**
     * @return array
     */
    public function provideParentIdSiteIdAndCount()
    {
        return array(
            array(NodeInterface::ROOT_NODE_ID, '2', 5),
            array('fixture_page_community', '2', 0),
            array('fixture_page_what_is_orchestra', '2', 0),
        );
    }

    /**
     * Tets find last version by type
     */
    public function testFindLastVersionByType()
    {
        $node = $this->repository->findInLastVersion('root', 'fr', '2');
        $nodes = $this->repository->findLastVersionByType('2');

        $this->assertSameNode('fr', $node->getVersion(), '2', $nodes[NodeInterface::ROOT_NODE_ID]);
    }

    /**
     * @param string        $language
     * @param int           $version
     * @param string        $siteId
     * @param NodeInterface $node
     * @param string        $nodeId
     */
    protected function assertSameNode($language, $version, $siteId, $node, $nodeId = NodeInterface::ROOT_NODE_ID)
    {
        $this->assertInstanceOf('OpenOrchestra\ModelInterface\Model\NodeInterface', $node);
        $this->assertSame($nodeId, $node->getNodeId());
        $this->assertSame($language, $node->getLanguage());
        $this->assertSame($version, $node->getVersion());
        $this->assertSame($siteId, $node->getSiteId());
        $this->assertSame(false, $node->isDeleted());
    }

    /**
     * @param string      $siteId
     * @param int         $nodeNumber
     * @param int         $version
     * @param string      $language
     * @param string|null $nodeId
     *
     * @dataProvider provideForGetFooter()
     */
    public function testGetFooterTree($siteId, $nodeNumber, $version, $language = 'fr', $nodeId = null)
    {
        $nodes = $this->repository->getFooterTree($language, $siteId);

        $this->assertCount($nodeNumber, $nodes);
        if ($nodeId) {
            $this->assertSameNode($language, $version, $siteId, $nodes[0], $nodeId);
            $this->assertSame('published', $nodes[0]->getStatus()->getName());
        }
    }

    /**
     * @return array
     */
    public function provideForGetFooter()
    {
        return array(
            array('2', 1, '1', 'fr', 'fixture_page_legal_mentions'),
            array('2', 1, '1', 'en'),
            array('2', 1, '1'),
        );
    }

    /**
     * @param string      $siteId
     * @param int         $nodeNumber
     * @param int         $version
     * @param string      $language
     *
     * @dataProvider provideForGetMenu()
     */
    public function testGetMenuTree($siteId, $nodeNumber, $version, $language = 'fr')
    {
        $nodes = $this->repository->getMenuTree($language, $siteId);

        $this->assertCount($nodeNumber, $nodes);
        $this->assertSameNode($language, $version, $siteId, $nodes[0]);
        $this->assertSame('published', $nodes[0]->getStatus()->getName());
    }

    /**
     * @return array
     */
    public function provideForGetMenu()
    {
        return array(
            array('2', 4, '1', 'fr'),
            array('2', 4, '1', 'en'),
        );
    }

    /**
     * @param string $nodeId
     * @param int    $nbLevel
     * @param int    $nodeNumber
     * @param int    $version
     * @param string $siteId
     * @param string $local
     *
     * @dataProvider provideForGetSubMenu
     */
    public function testGetSubMenu($nodeId, $nbLevel, $nodeNumber, $version, $siteId, $local)
    {
        $nodes = $this->repository->getSubMenu($nodeId, $nbLevel, $local, $siteId);

        $this->assertCount($nodeNumber, $nodes);
        if ($nodeNumber > 0) {
            $this->assertSameNode($local, $version, $siteId, $nodes[0], $nodeId);
            $this->assertSame('published', $nodes[0]->getStatus()->getName());
        }
    }

    /**
     * @return array
     */
    public function provideForGetSubMenu()
    {
        return array(
            array(NodeInterface::ROOT_NODE_ID, 1, 6, '1', '2', 'fr'),
            array(NodeInterface::ROOT_NODE_ID, 2, 6, '1', '2', 'fr'),
            array(NodeInterface::ROOT_NODE_ID, 0, 6, '1', '2', 'fr'),
            array(NodeInterface::ROOT_NODE_ID, 0, 6, '1', '2', 'en'),
            array('fixture_page_community', 1, 1, '1', '2', 'fr'),
            array('fixture_page_community', 1, 1, '1', '2', 'en'),
            array('page_unexistant', 1, 0, 1, '2', 'fr'),
        );
    }

    /**
     * @param string $language
     * @param string $siteId
     * @param int    $count
     *
     * @dataProvider provideLanguageSiteIdAndCount
     */
    public function testFindPublishedByLanguageAndSiteId($language, $siteId, $count)
    {
        $nodes = $this->repository->findPublishedByLanguageAndSiteId($language, $siteId);

        $this->assertCount($count, $nodes);
        foreach ($nodes as $node) {
            $this->assertSame($language, $node->getLanguage());
        }
    }

    /**
     * @return array
     */
    public function provideLanguageSiteIdAndCount()
    {
        return array(
            array('en', '2', 6),
            array('fr', '2', 6),
        );
    }

    /**
     * @param string       $user
     * @param string       $siteId
     * @param array        $eventTypes
     * @param boolean|null $published
     * @param int          $limit
     * @param array|null   $sort
     * @param int          $count
     *
     * @dataProvider provideFindByHistoryAndSiteId
     */
    public function testFindByHistoryAndSiteId($user, $siteId, array $eventTypes, $published, $limit, $sort, $count)
    {
        $user = $this->userRepository->findOneByUsername($user);

        $this->assertCount(
            $count,
            $this->repository->findByHistoryAndSiteId($user->getId(), $siteId, $eventTypes, $published, $limit, $sort)
        );
    }

    /**
     * @return array
     */
    public function provideFindByHistoryAndSiteId()
    {
        return array(
            array('p-admin', '2', array(NodeEvents::NODE_CREATION), null, 10, array('updatedAt' => -1), 0),
            array('p-admin', '2', array(NodeEvents::NODE_CREATION), false, 10, null, 0),
            array('p-admin', '2', array(NodeEvents::NODE_CREATION), true, 10, null, 0),
            array('developer', '2', array(NodeEvents::NODE_UPDATE, NodeEvents::NODE_CREATION), false, 10, null, 1),
        );
    }

    /**
     * @param string $nodeId
     * @param string $language
     * @param int    $count
     *
     * @dataProvider provideFindPublishedSortedVersionData
     */
    public function testFindPublishedSortedByVersion($nodeId, $language, $count)
    {
        $this->assertCount($count, $this->repository->findPublishedSortedByVersion($nodeId, $language, '2'));
    }

    /**
     * @return array
     */
    public function provideFindPublishedSortedVersionData()
    {
        return array(
            array(NodeInterface::ROOT_NODE_ID, 'fr', 1),
            array(NodeInterface::ROOT_NODE_ID, 'en', 1),
            array('fixture_page_contact', 'en', 1),
        );
    }

    /**
     * @param string $language
     * @apram int    $expectedCount
     *
     * @dataProvider provideLanguage
     */
    public function testFindSubTreeByPath($language, $expectedCount)
    {
        $nodes = $this->repository->findSubTreeByPath('root', '2', $language);

        $this->assertCount($expectedCount, $nodes);
    }

    /**
     * @return array
     */
    public function provideLanguage()
    {
        return array(
            array('en', 5),
            array('fr', 5),
        );
    }

    /**
     * @param string $parentId
     * @param string $routePattern
     * @param string $nodeId
     *
     * @dataProvider provideParentRouteAndNodeId
     */
    public function testFindByParentAndRoutePattern($parentId, $routePattern, $nodeId)
    {
        $this->assertEmpty($this->repository->findByParentAndRoutePattern($parentId, $routePattern, $nodeId, '2'));
    }

    /**
     * @return array
     */
    public function provideParentRouteAndNodeId()
    {
        return array(
            array(NodeInterface::ROOT_NODE_ID, 'page-contact', 'fixture_page_contact'),
            array(NodeInterface::ROOT_NODE_ID, 'mentions-legales', 'fixture_page_legal_mentions'),
        );
    }

    /**
     * @param string $parentId
     * @param int    $order
     * @param string $nodeId
     * @param bool   $expectedValue
     * @param string $siteId
     *
     * @dataProvider provideParentAndOrder
     */
    public function testHasOtherNodeWithSameParentAndOrder($parentId, $order, $nodeId, $expectedValue, $siteId = '2')
    {
        $this->assertSame($expectedValue, $this->repository->hasOtherNodeWithSameParentAndOrder($parentId, $order, $nodeId, $siteId));
    }

    /**
     * @return array
     */
    public function provideParentAndOrder()
    {
        return array(
            array(NodeInterface::ROOT_NODE_ID, 10, 'fixture_page_contact', true),
            array(NodeInterface::ROOT_NODE_ID, 0, 'fixture_page_contact', false),
            array('fixture_page_legal_mentions', 0, 'fakeID', false),
            array(NodeInterface::ROOT_NODE_ID, 0, 'fakeID', false, '3'),
        );
    }

    /**
     * Test has statused element
     */
    public function testHasStatusedElement()
    {
        $statusRepository = static::$kernel->getContainer()->get('open_orchestra_model.repository.status');
        $status = $statusRepository->findOneByInitial();

        $this->assertTrue($this->repository->hasStatusedElement($status));
    }

    /**
     * @return array
     */
    public function provideNodeIdAndLanguageForPublishedFlag()
    {
        return array(
            'root in fr' => array(NodeInterface::ROOT_NODE_ID, 'fr'),
            'root in en' => array(NodeInterface::ROOT_NODE_ID, 'en'),
            'community in fr' => array('fixture_page_community', 'fr'),
            'community in en' => array('fixture_page_community', 'en'),
        );
    }

    /**
     * @param string  $siteId
     * @param integer $expectedCount
     *
     * @dataProvider provideFindPublishedByType
     */
    public function testFindPublishedByType($siteId, $expectedCount)
    {
        $this->assertCount($expectedCount, $this->repository->findPublishedByType($siteId));
    }

    /**
     * @return array
     */
    public function provideFindPublishedByType()
    {
        return array(
            array("1", 0),
            array("2", 17),
        );
    }

    /**
     * @param string  $path
     * @param string  $siteId
     * @param string  $language
     * @param integer $expectedCount
     *
     * @dataProvider provideFindPublishedByPathAndLanguage
     */
    public function testFindPublishedByPathAndLanguage($path, $siteId, $language, $expectedCount)
    {
        $this->assertCount($expectedCount, $this->repository->findPublishedByPathAndLanguage($path, $siteId, $language));
    }

    /**
     * @return array
     */
    public function provideFindPublishedByPathAndLanguage()
    {
        return array(
            array("root", "2", "en", 6),
            array("transverse", "2", "en", 0),
        );
    }

    /**
     * @param string  $path
     * @param string  $siteId
     * @param string  $language
     * @param integer $expectedCount
     *
     * @dataProvider provideFindByIncludedPathSiteIdAndLanguage
     */
    public function testFindByIncludedPathSiteIdAndLanguage($path, $siteId, $language, $expectedCount)
    {
        $this->assertCount($expectedCount, $this->repository->findByIncludedPathSiteIdAndLanguage($path, $siteId, $language));
    }

    /**
     * @return array
     */
    public function provideFindByIncludedPathSiteIdAndLanguage()
    {
        return array(
            array("root", "2", "en", 7),
        );
    }

    /**
     * test find tree node
     */
    public function testFindTreeNode()
    {
        $tree = $this->repository->findTreeNode('2', 'fr', '-');

        $this->assertCount(3, $tree);

        $nodeRootTree = $tree[0];
        $nodeRoot = $nodeRootTree['node'];
        $this->assertCount(5, $nodeRootTree['child']);
        $this->assertSame('root', $nodeRoot['nodeId']);
        $childrenRoot = $nodeRootTree['child'];
        $orderNodeId = array('fixture_page_community', 'fixture_page_news', 'fixture_page_contact', 'fixture_page_legal_mentions', 'fixture_auto_unpublish');
        foreach ($childrenRoot as $index => $child) {
            $this->assertCount(0, $child['child']);
            $this->assertSame($orderNodeId[$index], $child['node']['nodeId']);
        }

        $node404Tree = $tree[1];
        $node404 = $node404Tree['node'];
        $this->assertCount(0, $node404Tree['child']);
        $this->assertSame('errorPage404', $node404['nodeId']);

        $node503Tree = $tree[2];
        $node503 = $node503Tree['node'];
        $this->assertCount(0, $node503Tree['child']);
        $this->assertSame('errorPage503', $node503['nodeId']);
    }

    /**
     * @param string $siteId
     * @param string $language
     * @param int    $count
     *
     * @dataProvider provideSiteIdAndLanguage
     */
    public function testCount($siteId, $language, $count)
    {
        $this->assertEquals($count, $this->repository->count($siteId, $language));
    }

    /**
     * @return array
     */
    public function provideSiteIdAndLanguage()
    {
        return array(
            array('2', 'fr', 8),
            array('2', 'en', 8),
            array('2', 'de', 7),
            array('3', 'fr', 1),
        );
    }

    /**
     * @param PaginateFinderConfiguration $configuration
     * @param string                      $siteId
     * @param string                      $language
     * @param int                         $count
     *
     * @dataProvider provideCountWithFilterPaginateConfiguration
     */
    public function testCountWithFilter($configuration, $siteId, $language, $count)
    {
        $this->assertEquals($count, $this->repository->countWithFilter($configuration, $siteId, $language));
    }

    /**
     * @return array
     */
    public function provideCountWithFilterPaginateConfiguration()
    {
        $configurationAllPaginate = PaginateFinderConfiguration::generateFromVariable(array(), 0, 100, array());
        $configurationOrder = PaginateFinderConfiguration::generateFromVariable(array('updated_at' => 'desc'), 0, 100, array('updated_at' => 'updatedAt'));
        $configurationFilter = PaginateFinderConfiguration::generateFromVariable(array(), 0, 100, array(), array('name' => 'orchestra'));

        return array(
            'all' => array($configurationAllPaginate, '2', 'fr', 8),
            'order' => array($configurationOrder, '2', 'fr', 8),
            'filter' => array($configurationFilter, '2', 'fr', 1),
        );
    }

    /**
     * @param PaginateFinderConfiguration $configuration
     * @param string                      $siteId
     * @param string                      $language
     * @param int                         $count
     *
     * @dataProvider provideFindWithFilterPaginateConfiguration
     */
    public function testFindForPaginate($configuration, $siteId, $language, $count)
    {
        $this->assertCount($count, $this->repository->findForPaginate($configuration, $siteId, $language));
    }

    /**
     * @return array
     */
    public function provideFindWithFilterPaginateConfiguration()
    {
        $configurationAllPaginate = PaginateFinderConfiguration::generateFromVariable(array(), 0, 100, array());
        $configurationLimit = PaginateFinderConfiguration::generateFromVariable(array(), 0, 2, array());
        $configurationSkip = PaginateFinderConfiguration::generateFromVariable(array(), 2, 100, array());
        $configurationOrder = PaginateFinderConfiguration::generateFromVariable(array('updated_at' => 'desc'), 0, 100, array('updated_at' => 'updatedAt'));
        $configurationFilter = PaginateFinderConfiguration::generateFromVariable(array(), 0, 100, array(), array('name' => 'orchestra'));

        return array(
            'all' => array($configurationAllPaginate, '2', 'fr', 8),
            'limit' => array($configurationLimit, '2', 'fr', 2),
            'skip' => array($configurationSkip, '2', 'fr', 6),
            'order' => array($configurationOrder, '2', 'fr', 8),
            'filter' => array($configurationFilter, '2', 'fr', 1),
        );
    }

    /**
     * Test update order of brothers
     */
    public function testUpdateOrderOfBrothers()
    {
        $dm = static::$kernel->getContainer()->get('object_manager');
        $nodeNews = $this->repository->findOneByNodeAndSite('fixture_page_news', '2');
        $nodeCommunity = $this->repository->findOneByNodeAndSite('fixture_page_community', '2');
        $nodeContact= $this->repository->findOneByNodeAndSite('fixture_page_contact', '2');
        $dm->detach($nodeContact);
        $dm->detach($nodeCommunity);
        $dm->detach($nodeNews);

        $this->repository->updateOrderOfBrothers($nodeNews->getSiteId(), $nodeNews->getNodeId(), $nodeNews->getOrder(), $nodeNews->getParentId());

        $nodeNewsAfterUpdate = $this->repository->findOneByNodeAndSite('fixture_page_news', '2');
        $nodeCommunityAfterUpdate = $this->repository->findOneByNodeAndSite('fixture_page_community', '2');
        $nodeContactAfterUpdate = $this->repository->findOneByNodeAndSite('fixture_page_contact', '2');

        $this->assertSame($nodeNews->getOrder(), $nodeNewsAfterUpdate->getOrder());
        $this->assertSame($nodeCommunity->getOrder(), $nodeCommunityAfterUpdate->getOrder());
        $this->assertSame($nodeContact->getOrder() + 1, $nodeContactAfterUpdate->getOrder());

    }

    /**
     * Test remove block in area
     */
    public function testRemoveBlockInArea()
    {
        $dm = static::$kernel->getContainer()->get('object_manager');
        $node = $this->repository->findInLastVersion('root', 'fr', '2');
        $block = $node->getArea('main')->getBlocks()[0];
        $this->assertCount(2, $node->getArea('main')->getBlocks());

        $this->repository->removeBlockInArea($block->getId(), 'main', $node->getNodeId(), $node->getSiteId(), $node->getLanguage(), $node->getVersion());

        $dm->detach($node);
        $dm->detach($block);
        $node = $this->repository->findInLastVersion('root', 'fr', '2');
        $blocks = $node->getArea('main')->getBlocks();
        $this->assertCount(1, $blocks);

        $node->getArea('main')->addBlock($block);
        $dm->persist($block);
        $dm->flush();
    }

    /**
     * @param string $nodeId
     * @param string $siteId
     * @param string $areaId
     * @param int    $count
     *
     * @dataProvider provideFindByNodeIdAndSiteIdWithBlocksInArea
     */
    public function testFindByNodeIdAndSiteIdWithBlocksInArea($nodeId, $siteId, $areaId, $count)
    {
        $nodes = $this->repository->findByNodeIdAndSiteIdWithBlocksInArea($nodeId, $siteId, $areaId);
        $this->assertCount($count, $nodes);
    }

    /**
     * @return array
     */
    public function provideFindByNodeIdAndSiteIdWithBlocksInArea()
    {
        return array(
            array('root', '2', 'main', 3),
            array('root', 'fake', 'footer', 0),
        );
    }

    /**
     * Test remove node version
     */
    public function testRemoveVersion()
    {
        $dm = static::$kernel->getContainer()->get('object_manager');
        $node = $this->repository->findVersionNotDeleted('root', 'fr', '2', '1');
        $storageIds = array($node->geTId());
        $dm->detach($node);

        $this->repository->removeNodeVersions($storageIds);
        $this->assertNull($this->repository->findVersionNotDeleted('root', 'fr', '2', '1'));

        $dm->persist($node);
        $dm->flush();
    }

    /**
     * @param string $language
     * @param string $siteId
     * @param int    $count
     *
     * @dataProvider provideLanguageAndSiteIdSpecialPage
     */
    public function testFindAllPublishedSpecialPage($language, $siteId, $count)
    {
        $nodes = $this->repository->findAllPublishedSpecialPage($language, $siteId);
        $this->assertCount($count, $nodes);
    }

    /**
     * @param string $language
     * @param string $siteId
     * @param int    $count
     *
     * @dataProvider provideLanguageAndSiteIdSpecialPage
     */
    public function testFindAllSpecialPage($language, $siteId, $count)
    {
        $nodes = $this->repository->findAllSpecialPage($language, $siteId);
        $this->assertCount($count, $nodes);
    }

    /**
     * @return array
     */
    public function provideLanguageAndSiteIdSpecialPage()
    {
        return array(
            array('fr', '2', 1),
            array('en', '2', 1),
            array('de', '2', 1),
            array('fr', '3', 0),
            array('en', '3', 0),
            array('de', '3', 0),
        );
    }

    /**
     * @param string $nodeId
     * @param string $language
     * @param string $siteId
     * @param string $name
     * @param int    $count
     *
     * @dataProvider provideCountOtherNodeWithSameSpecialPageName
     */
    public function testCountOtherNodeWithSameSpecialPageName($nodeId, $language, $siteId, $name, $count)
    {
        $nodesCount = $this->repository->countOtherNodeWithSameSpecialPageName($nodeId, $siteId, $language, $name);
        $this->assertSame($count, $nodesCount);
    }

    /**
     * @return array
     */
    public function provideCountOtherNodeWithSameSpecialPageName()
    {
        return array(
            array('root', 'fr', '2', 'DEFAULT', 1),
            array('root', 'en', '2', 'DEFAULT', 1),
            array('root', 'de', '2', 'DEFAULT', 1),
            array('root', 'fr', '2', 'FAKE', 0),
            array('root', 'en', '2', 'FAKE', 0),
            array('root', 'de', '2', 'FAKE', 0),
            array('fixture_page_contact', 'fr', '2', 'DEFAULT', 0),
            array('fixture_page_contact', 'en', '2', 'DEFAULT', 0),
            array('fixture_page_contact', 'de', '2', 'DEFAULT', 0),
        );
    }

    /**
     * Test update use Reference
     */
    public function testUpdateUseReference()
    {
        $nodeId = 'root';
        $siteId = '3';
        $entityType = NodeInterface::ENTITY_TYPE;
        $referenceNodeId = 'fakeReferenceId';
        $this->repository->updateUseReference($referenceNodeId, $nodeId, $siteId, $entityType);
        $nodes = $this->repository->findByNodeAndSite($nodeId, $siteId);
        foreach ($nodes as $node) {
            $this->assertTrue(array_key_exists($referenceNodeId, $node->getUseReferences($entityType)));
        }
    }

    /**
     * Test soft delete node
     */
    public function testSoftDeleteAndRestoreNode()
    {
        $nodeId = 'root';
        $siteId = '2';

        $this->repository->softDeleteNode($nodeId, $siteId);
        $nodes = $this->repository->findByNodeAndSite($nodeId, $siteId);
        foreach ($nodes as $node) {
            $this->assertTrue($node->isDeleted());
        }
        $this->repository->restoreDeletedNode($nodeId, $siteId);

        $documentManager = static::$kernel->getContainer()->get('object_manager');
        $documentManager->clear();
        $documentManager->close();

        $nodes = $this->repository->findByNodeAndSite($nodeId, $siteId);
        foreach ($nodes as $node) {
            $this->assertFalse($node->isDeleted());
        }
    }

    /**
     * @param string   $nodeId
     * @param string   $siteId
     * @param bool     $has
     *
     * @dataProvider provideNodeNotOffline
     */
    public function testHasNodeIdWithoutAutoUnpublishToState($nodeId, $siteId, $has)
    {
        $this->assertSame($has, $this->repository->hasNodeIdWithoutAutoUnpublishToState($nodeId, $siteId));
    }

    /**
     * @return array
     */
    public function provideNodeNotOffline()
    {
        return array(
            array('root', '2', true),
            array('fixture_page_contact', '2', true)
        );
    }

    /**
     * @param string $parentId
     * @param string $siteId
     * @param int    $count
     *
     * @dataProvider provideCountByParentId
     */
    public function testCountByParentId($parentId, $siteId, $count)
    {
        $this->assertEquals($count, $this->repository->countByParentId($parentId, $siteId));
    }

    /**
     * @return array
     */
    public function provideCountByParentId()
    {
        return array(
            array('fixture_page_contact', '2', 0),
            array('root', '2', 15)
        );
    }

    /**
     * Test update embedded status
     */
    public function testUpdateEmbeddedStatus()
    {
        $statusRepository = static::$kernel->getContainer()->get('open_orchestra_model.repository.status');
        $status = $statusRepository->findOneByName('published');
        $fakeColor = 'fakeColor';
        $saveColor = $status->getDisplayColor();
        $status->setDisplayColor($fakeColor);
        $this->repository->updateEmbeddedStatus($status);

        $node = $this->repository->findOnePublished('root', 'fr', '2');
        $this->assertEquals($fakeColor, $node->getStatus()->getDisplayColor());

        $status->setDisplayColor($saveColor);
        $this->repository->updateEmbeddedStatus($status);
    }

    /**
     * Test findLastVersionByLanguage
     * @param string $siteId
     * @param string $language
     * @param int    $count
     *
     * @dataProvider provideSiteAndLanguage
     */
    public function testFindLastVersionByLanguage($siteId, $language, $count)
    {
        $nodes = $this->repository->findLastVersionByLanguage($siteId, $language);

        $this->assertEquals($count, count($nodes));
    }

    /**
     * @return array
     */
    public function provideSiteAndLanguage()
    {
        return array(
            array('2', 'fr', 8),
            array('2', 'en', 8),
            array('2', 'es', 0),
            array('3', 'fr', 1),
       );
    }

}
