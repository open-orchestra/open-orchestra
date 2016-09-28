<?php

namespace OpenOrchestra\FunctionalTests\ModelBundle\Repository;

use OpenOrchestra\BaseBundle\Tests\AbstractTest\AbstractKernelTestCase;
use OpenOrchestra\ModelInterface\Model\NodeInterface;
use OpenOrchestra\ModelBundle\Repository\NodeRepository;
use Phake;

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
    public function testFindOneCurrentlyPublished($language, $version, $siteId)
    {
        $node = $this->repository->findOneCurrentlyPublished(NodeInterface::ROOT_NODE_ID, $language, $siteId);

        $this->assertSameNode($language, $version, $siteId, $node);
    }

    /**
     * @return array
     */
    public function provideLanguageLastVersionAndSiteId()
    {
        return array(
            array('en', 1, '2'),
            array('fr', 1, '2'),
        );
    }

    /**
     * @param $language
     * @param $version
     * @param $siteId
     *
     * @dataProvider provideLanguageLastVersionAndSiteId
     */
    public function testFindOneByNodeIdAndLanguageAndVersionAndSiteIdWithPublishedDataSet($language, $version, $siteId)
    {
        $node = $this->repository->findVersion(NodeInterface::ROOT_NODE_ID, $language, $siteId, $version);

        $this->assertSameNode($language, $version, $siteId, $node);
    }

    /**
     * @param string $language
     * @param int    $version
     * @param string $siteId
     * @param int    $versionExpected
     *
     * @dataProvider provideLanguageLastVersionAndSiteIdNotPublished
     */
    public function testFindOneByNodeIdAndLanguageAndVersionAndSiteIdWithNotPublishedDataSet($language, $version = null, $siteId, $versionExpected)
    {
        $node = $this->repository->findVersion(NodeInterface::ROOT_NODE_ID, $language, $siteId, $version);

        $this->assertSameNode($language, $versionExpected, $siteId, $node);
        $this->assertSame('draft', $node->getStatus()->getName());
    }

    /**
     * @return array
     */
    public function provideLanguageLastVersionAndSiteIdNotPublished()
    {
        return array(
            array('fr', 2, '2', 2),
            array('fr', null, '2', 2),
        );
    }

    /**
     * @param string $language
     * @param int    $version
     * @param string $siteId
     * @param int    $versionExpected
     *
     * @dataProvider provideLanguageLastVersionAndSiteIdNotPublished
     */
    public function testFindInLastVersion($language, $version = null, $siteId, $versionExpected)
    {
        $node = $this->repository->findInLastVersion(NodeInterface::ROOT_NODE_ID, $language, $siteId);

        $this->assertSameNode($language, $versionExpected, $siteId, $node);
    }

    /**
     * @param int    $countVersions
     * @param string $language
     * @param string $siteId
     *
     * @dataProvider provideLanguageAndVersionListAndSiteId
     */
    public function testFindByNodeAndLanguageAndSite($countVersions, $language, $siteId)
    {
        $nodes = $this->repository->findByNodeAndLanguageAndSite(NodeInterface::ROOT_NODE_ID, $language, $siteId);

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
     * @return array
     */
    public function provideLanguageAndVersionListAndSiteId()
    {
        return array(
            array(1, 'en', '2'),
            array(2, 'fr', '2'),
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
            array(NodeInterface::ROOT_NODE_ID, '2', 3),
            array(NodeInterface::TRANSVERSE_NODE_ID, '2', 3),
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
            array(NodeInterface::TRANSVERSE_NODE_ID, '2', 0),
            array('fixture_page_what_is_orchestra', '2', 0),
        );
    }

    /**
     * @param string $path
     * @param string $siteId
     * @param int    $count
     *
     * @dataProvider providePathSiteIdAndCount
     */
    public function testFindByIncludedPathAndSiteId($path, $siteId, $count)
    {
        $nodes = $this->repository->findByIncludedPathAndSiteId($path, $siteId);

        $this->assertGreaterThanOrEqual($count, count($nodes));
    }

    /**
     * @return array
     */
    public function providePathSiteIdAndCount()
    {
        return array(
            array('root', '2', 5),
            array('root/fixture_page_community', '2', 0),
            array('transverse', '2', 0),
        );
    }

    /**
     * @param string $siteId
     * @param int    $version
     *
     * @dataProvider provideSiteIdAndLastVersion
     */
    public function testFindLastVersionByType($siteId, $version)
    {
        $nodes = $this->repository->findLastVersionByType($siteId);

        $this->assertSameNode('fr', $version, $siteId, $nodes[NodeInterface::ROOT_NODE_ID]);
    }

    /**
     * @return array
     */
    public function provideSiteIdAndLastVersion()
    {
        return array(
            array('2', 2),
        );
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
            $this->assertSameNode($language, $version, $siteId, $nodes[$nodeId], $nodeId);
            $this->assertSame('published', $nodes[$nodeId]->getStatus()->getName());
        }
    }

    /**
     * @return array
     */
    public function provideForGetFooter()
    {
        return array(
            array('2', 1, 1, 'fr', 'fixture_page_legal_mentions'),
            array('2', 1, 1, 'en'),
            array('2', 1, 1),
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
        $this->assertSameNode($language, $version, $siteId, $nodes[NodeInterface::ROOT_NODE_ID]);
        $this->assertSame('published', $nodes[NodeInterface::ROOT_NODE_ID]->getStatus()->getName());
    }

    /**
     * @return array
     */
    public function provideForGetMenu()
    {
        return array(
            array('2', 4, 1, 'fr'),
            array('2', 4, 1, 'en'),
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
            array(NodeInterface::ROOT_NODE_ID, 1, 8, 1, '2', 'fr'),
            array(NodeInterface::ROOT_NODE_ID, 2, 8, 1, '2', 'fr'),
            array(NodeInterface::ROOT_NODE_ID, 0, 8, 1, '2', 'fr'),
            array(NodeInterface::ROOT_NODE_ID, 0, 7, 1, '2', 'en'),
            array('fixture_page_community', 1, 1, 1, '2', 'fr'),
            array('fixture_page_community', 1, 1, 1, '2', 'en'),
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
    public function testFindCurrentlyPublishedVersion($language, $siteId, $count)
    {
        $nodes = $this->repository->findCurrentlyPublishedVersion($language, $siteId);

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
     * @param string       $author
     * @param string       $siteId
     * @param boolean|null $published
     * @param int          $limit
     * @param array|null   $sort
     * @param int          $count
     *
     * @dataProvider provideFindByAuthorAndSiteId
     */
    public function testFindByAuthorAndSiteId($author, $siteId, $published, $limit, $sort, $count)
    {
        $this->assertCount(
            $count,
            $this->repository->findByAuthorAndSiteId($author, $siteId, $published, $limit, $sort)
        );
    }

    /**
     * @return array
     */
    public function provideFindByAuthorAndSiteId()
    {
        return array(
            array('fake_admin', '2', null, 10, array('updatedAt' => -1), 3),
            array('fake_admin', '2', false, 10, null, 1),
            array('fake_admin', '2', true, 10, null, 2),
            array('fake_admin', '2', true, 2, null, 2),
            array('fake_contributor', '2', false, 10, null, 0),
            array('fake_contributor', '2', null, 10, null, 0),
            array('fake_admin', '3', true, 10, null, 1),
        );
    }

    /**
     * @param string       $user
     * @param string       $siteId
     * @param boolean|null $published
     * @param int          $limit
     * @param array|null   $sort
     * @param int          $count
     *
     * @dataProvider provideFindByReportAndSiteId
     */
    public function testFindByReportAndSiteId($user, $siteId, $published, $limit, $sort, $count)
    {
        $user = $this->userRepository->findOneByUsername($user);

        $this->assertCount(
            $count,
            $this->repository->findByAuthorAndSiteId($user->getId(), $siteId, $published, $limit, $sort)
        );
    }

    /**
     * @return array
     */
    public function provideFindByReportAndSiteId()
    {
        return array(
            array('admin', '2', null, 10, array('updatedAt' => -1), 1),
            array('admin', '2', false, 10, null, 1),
            array('admin', '2', true, 10, null, 1),
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
            array('en', 6),
            array('fr', 7),
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
            array(NodeInterface::TRANSVERSE_NODE_ID, 1, '-', false,),
        );
    }

    /**
     * @param string $type
     * @param int    $count
     *
     * @dataProvider provideNodeTypeAndCount
     */
    public function testFindAllNodesOfTypeInLastPublishedVersionForSite($type, $count)
    {
        $this->assertCount($count, $this->repository->findAllNodesOfTypeInLastPublishedVersionForSite($type, '2'));
    }

    /**
     * @return array
     */
    public function provideNodeTypeAndCount()
    {
        return array(
            array(NodeInterface::TYPE_DEFAULT, 15),
            array(NodeInterface::TYPE_ERROR, 6),
            array(NodeInterface::TYPE_TRANSVERSE, 0),
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
     * Test find by site and defaultTheme
     */
    public function testFindBySiteIdAndDefaultTheme()
    {
        $this->assertCount(0, $this->repository->findBySiteIdAndDefaultTheme('2', false));
        $this->assertGreaterThanOrEqual(16, $this->repository->findBySiteIdAndDefaultTheme('2', true));
    }

    /**
     * @param string $nodeId
     * @param string $language
     *
     * @dataProvider provideNodeIdAndLanguageForPublishedFlag
     */
    public function testfindAllCurrentlyPublishedByElementId($nodeId, $language)
    {
        $node = Phake::mock(NodeInterface::CLASS);
        Phake::when($node)->getNodeId()->thenReturn($nodeId);
        Phake::when($node)->getLanguage()->thenReturn($language);
        Phake::when($node)->getSiteId()->thenReturn('2');

        $this->assertCount(1, $this->repository->findAllCurrentlyPublishedByElementId($node));
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
     * @dataProvider provideFindLastVersionByTypeCurrentlyPublished
     */
    public function testFindLastVersionByTypeCurrentlyPublished($siteId, $expectedCount)
    {
        $this->assertCount($expectedCount, $this->repository->findLastVersionByTypeCurrentlyPublished($siteId));
    }

    /**
     * @return array
     */
    public function provideFindLastVersionByTypeCurrentlyPublished()
    {
        return array(
            array("1", 0),
            array("2", 16),
        );
    }

    /**
     * @param string  $path
     * @param string  $siteId
     * @param integer $expectedCount
     *
     * @dataProvider provideFindByPathCurrentlyPublished
     */
    public function testFindByPathCurrentlyPublished($path, $siteId, $expectedCount)
    {
        $this->assertCount($expectedCount, $this->repository->findByPathCurrentlyPublished($path, $siteId));
    }

    /**
     * @return array
     */
    public function provideFindByPathCurrentlyPublished()
    {
        return array(
            array("root", "2", 8),
            array("transverse", "2", 0),
        );
    }

    /**
     * @param string  $path
     * @param string  $siteId
     * @param string  $language
     * @param integer $expectedCount
     *
     * @dataProvider provideFindByPathCurrentlyPublishedAndLanguage
     */
    public function testFindByPathCurrentlyPublishedAndLanguage($path, $siteId, $language, $expectedCount)
    {
        $this->assertCount($expectedCount, $this->repository->findByPathCurrentlyPublishedAndLanguage($path, $siteId, $language));
    }

    /**
     * @return array
     */
    public function provideFindByPathCurrentlyPublishedAndLanguage()
    {
        return array(
            array("root", "2", "en", 8),
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
            array("root", "2", "en", 8),
            array("transverse", "2", "en", 1),
        );
    }

    /**
     * @param string  $theme
     * @param integer $expectedCount
     *
     * @dataProvider provideTheme
     */
    public function testFindByTheme($theme, $expectedCount)
    {
        $this->assertCount($expectedCount, $this->repository->FindByTheme($theme));
    }

    /**
     * @return array
     */
    public function provideTheme()
    {
        return array(
            array("fakeTheme", 0),
            array("themePresentation", 29),
        );
    }
}
