<?php

namespace PHPOrchestra\CMSBundle\Test\Helper;

use PHPOrchestra\CMSBundle\Helper\IndexHelper;
use PHPOrchestra\CMSBundle\Document\DocumentManager;
use Model\PHPOrchestraCMSBundle\Base\Node;

/**
 * Test Unit
 * 
 * @author benjamin fouché <benjamin.fouche@businessdecision.com>
 *
 */
class IndexHelperTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Symfony\Component\DependencyInjection\Container
     */
    protected $container = null;
    
    /**
     * @var PHPOrchestra\CMSBundle\Helper\IndexHelper;
     */
    protected $indexHelper = null;
    
    /**
     * @var PHPOrchestra\BlockBundle\IndexCommand\SolrIndexCommand
     */
    protected $solrIndex = null;
    
    /**
     * @var Mandango\Mandango
     */
    protected $mandango = null;
    
    /**
     * @var Mandango\MandangoDocument
     */
    protected $mandangoDoc = null;


    /**
     * Initialize unit test
     *
     * @see PHPUnit_Framework_TestCase::setUp()
     */
    public function setUp()
    {
        $this->container = $this->getMock('\\Symfony\\Component\\DependencyInjection\\Container');
        
        $this->solrIndex = $this->getMock(
            '\\PHPOrchestra\\BlockBundle\\IndexCommand\\SolrIndexCommand',
            array(),
            array($this->container)
        );
        
        $this->mandango = $this->getMock('PHPOrchestra\\CMSBundle\\Test\\Mock\\Mandango');
        $this->mandangoDoc = $this->getMock(
            'PHPOrchestra\\CMSBundle\\Test\\Mock\\MandangoDocument',
            array(),
            array($this->mandango)
        );
        
        $this->container->expects($this->at(0))->method('getParameter')->will($this->returnValue(array('solr')));
        
        $this->indexHelper = new IndexHelper($this->container);
    }


    /**
     * Test index()
     */
    public function testIndex()
    {
        $this->mandango->expects($this->any())->method('create')->will($this->returnValue($this->mandangoDoc));
         
        
        $this->container->expects($this->at(0))->method('get')->will($this->returnValue($this->solrIndex));
        $this->container->expects($this->any())->method('get')->will($this->returnValue($this->mandango));
        
        $nodes = $this->getNodes();
        
        $this->indexHelper->index($nodes, 'Node');
        
    }


    /**
     * Test deleteIndex()
     */
    public function testDeleteIndex()
    {
        $repository = $this->getMock(
            'PHPOrchestra\\CMSBundle\\Test\\Mock\\MandangoDocumentRepository',
            array('removeByDocId'),
            array($this->mandango)
        );
        
        $this->mandango->expects($this->any())->method('getRepository')->will($this->returnValue($repository));
        $this->container->expects($this->at(0))->method('get')->will($this->returnValue($this->solrIndex));
        //$this->container->expects($this->at(1))->method('get')->will($this->returnValue($this->mandango));
        
        $this->indexHelper->deleteIndex('fixture_full');
    }


    /**
     * Test addListIndex()
     */
    public function testAddListIndex()
    {
        $this->mandango->expects($this->once())->method('create')->will($this->returnValue($this->mandangoDoc));

        $this->container->expects($this->any())->method('get')->will($this->returnValue($this->mandango));
        
        $node = $this->getNode();
        
        $this->indexHelper->addListIndex($node, 'Node');
    }


    /**
     * Create an array of Node
     *
     * @return multitype:\Model\PHPOrchestraCMSBundle\Node
     */
    public function getNodes()
    {
        $documentServices = $this->getMockBuilder('PHPOrchestra\\CMSBundle\\Test\\Mock\\Mandango')
        ->enableProxyingToOriginalMethods()
        ->getMock();
    
        $documentManager = new DocumentManager($documentServices);
    
        $home = $documentManager->createDocument('Node');
        $home->setSiteId(1);
        $home->setLanguage('fr');
        $home->setNodeId('fixture_home');
        $home->setParentId('superroot');
    
        $full = $documentManager->createDocument('Node');
        $full->setSiteId(1);
        $full->setNodeId('fixture_full');
        $full->setLanguage('fr');
        $full->setParentId('superroot');
    
        return array($home, $full);
    }
    
    /**
     * Create a Node
     * 
     * @return Node
     */
    public function getNode()
    {
        $documentServices = $this->getMockBuilder('PHPOrchestra\\CMSBundle\\Test\\Mock\\Mandango')
        ->enableProxyingToOriginalMethods()
        ->getMock();
        
        $documentManager = new DocumentManager($documentServices);
        
        $node = $documentManager->createDocument('Node');
        $node->setSiteId(1);
        $node->setLanguage('fr');
        $node->setNodeId('fixture_full');
        $node->setParentId('root');
        
        return $node;
    }
}
