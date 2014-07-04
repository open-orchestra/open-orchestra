<?php

namespace PHPOrchestra\CMSBundle\Test\Model;

use PHPOrchestra\CMSBundle\Model\NodeRepository;
use Model\PHPOrchestraCMSBundle\Node;

/**
 * Unit tests of NodeRepository
 *  
 * @author Benjamin Fouché <benjamin.fouche@businessdecision.com>
 *
 */
class NodeRepositoryTest extends \PHPUnit_Framework_TestCase
{
    
    /**
     * repository to be tested
     * 
     * @var PHPOrchestra\CMSBundle\Model\NodeRepository
     */
    protected $repository = null;

    /**
     * Database mock system
     * 
     * @var \PHPOrchestra\CMSBundle\Test\Mock\Mandango
     */
    protected $mandango = null;


    /**
     * Tests setup
     */
    public function setUp()
    {
        /**
         * Database mock system, using a fake result set
         *
         * @var \PHPOrchestra\CMSBundle\Test\Mock\Mandango
         */
        $this->mandango = $this->getMockBuilder('PHPOrchestra\\CMSBundle\\Test\\Mock\\Mandango')
        ->enableProxyingToOriginalMethods()
        ->getMock();

        $this->mandango->setDB(
            array(
                'Model\PHPOrchestraCMSBundle\Node' => array(
                    1 => array(
                        '_id'       => '1',
                        'node_id'   => 'root',
                        'parent_id' => '-',
                        'name'      => 'test1',
                        'alias'     => '',
                        'node_type' => 'page',
                        'status'    => 'published',
                        'deleted'   => false,
                        'inMenu'    => true,
                        'inFooter'  => true
                    ),
                    2 => array(
                        '_id'       => '2',
                        'node_id'   => 'superroot',
                        'parent_id' => '-',
                        'name'      => 'test2',
                        'alias'     => 'test',
                        'node_type' => 'page',
                        'status'    => 'published',
                        'deleted'   => false,
                        'inMenu'    => true,
                        'inFooter'  => true
                    ),
                )
            )
        );
        
        $this->repository = new NodeRepository($this->mandango);
    }


    /**
     * Create a tree with menu nodes
     */
/*    public function testGetMenuTree()
    {
        $result   = $this->repository->getMenuTree();
        var_dump($this->repository);
        $expected = $this->createTreeData();
        $this->assertEquals($expected, $result);
    }*/


    /**
     * Test getMenuTree
     */
    public function testGetMenuTree2()
    {
        $result   = $this->repository->getMenuTree();
        $this->assertEquals(array(), $result);
    }


    /**
     * Create a tree with footer nodes
     */
/*    public function testGetFooterTree()
    {
        $result   = $this->repository->getFooterTree();
        $expected = $this->createTreeData();
        $this->assertEquals($expected, $result);
    }*/


    public function testGetFooterTree2()
    {
        $result = $this->repository->getFooterTree();
        $this->assertEquals(array(), $result);
    }


    /**
     * Take nodes from mandango and create a tree
     */
/*    public function testGetTree()
    {
        $filter = array(
                'status' => 'published',
                'deleted' => false,
                'inFooter' => true,
        );

        $result   = $this->repository->getTree($filter);
        //var_dump($result);
        $expected = NodeRepositoryTest::createTreeData();
        //var_dump($expected);
        $this->assertEquals($expected, $result);
    }*/


    /**
     * Take nodes from mandango and create a tree
     */
    public function testGetTree2()
    {
        $filter = array(
            'status' => 'published',
            'deleted' => true,
            'inMenu' => true,
        );
        
        $result   = $this->repository->getTree($filter);
        $expected = array();
        $this->assertEquals($expected, $result);
    }


    /**
     * Take a list of nodes and create a tree
     */
    public function testNodeListAsTree()
    {
        $nodes    = $this->nodesListData();
        $result   = $this->repository->nodeListAsTree($nodes);
        $expected = $this->createTreeData();
        $this->assertEquals($expected, $result);
    }


    /**
     * Test unit getTreeUrl()
     */
    public function testGetTreeUrl()
    {
        $tree = $this->createTreeData();
        $generateUrl = $this->getMockBuilder('\\PHPOrchestra\\CMSBundle\\Routing\\PhpOrchestraUrlGenerator')
            ->disableOriginalConstructor()
            ->getMock();
        $container = $this->getMock('\\Symfony\\Component\\DependencyInjection\\Container');
        $container->expects($this->any())->method('get')->willReturn($generateUrl);
        $generateUrl->expects($this->at(0))->method('generate')->will($this->returnValue('/app_dev.php'));
        $generateUrl->expects($this->at(1))->method('generate')->will($this->returnValue('/app_dev.php/fixture-full'));
        
        $result = $this->repository->getTreeUrl($tree, $container);
        $expected = $this->createTreeUrl();
        
        $this->assertEquals($expected, $result);
    }

    
    /**
     * Test getAllNodes function
     */
    public function testGetAllNodes()
    {
        $result = $this->repository->getAllNodes();
        $this->assertEquals("root", $result[1]->getNodeId());
    }


    /**
     * Test getOne function
     */
    public function testGetOne()
    {
        $result = $this->repository->getOne('root');
        $this->assertEquals('root', $result->getNodeId());
    }
    
    
    /**
     * Test getAllNodeToIndex function
     */
    public function testGetAllNodeToIndex()
    {
        $result = $this->repository->getAllNodeToIndex();
        $this->assertEquals('root', $result[1]->getNodeId());
    }
    

    /**
     * Tree of nodes
     */
    public function createTreeData()
    {
        return array(
            array(
                'id'   => 'root',
                'text' => 'test1',
            ),
            array(
                'id'   => 'superroot',
                'text' => 'test2',
            )
        );
    }
    

    public function createTreeUrl()
    {
        return array(
            array(
                'id'   => 'root',
                'text' => 'test1',
                'url'  => '/app_dev.php',
            ),
            array(
                'id'   => 'superroot',
                'text' => 'test2',
                'url'  => '/app_dev.php/fixture-full',
            )
        );
    }


    /**
     * List of nodes object
     */
    public function nodesListData()
    {
        $node = new Node($this->mandango);
        $node->initializeDefaults();
        $node->setNodeId('root');
        $node->setParentId('-');
        $node->setName('test1');
        $node->setStatus('published');
        $node->setDeleted(false);
        $node->setInMenu(true);
        $node->setInFooter(true);
        
        $node2 = new Node($this->mandango);
        $node2->initializeDefaults();
        $node2->setNodeId('superroot');
        $node2->setParentId('-');
        $node2->setName('test2');
        $node2->setStatus('published');
        $node2->setDeleted(false);
        $node2->setInMenu(true);
        $node2->setInFooter(true);
        return array($node, $node2);
    }
}
