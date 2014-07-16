<?php

/*
 * Business & Decision - Commercial License
 *
 * Copyright 2014 Business & Decision.
 *
 * All rights reserved. You CANNOT use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell this Software or any parts of this
 * Software, without the written authorization of Business & Decision.
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * See LICENSE.txt file for the full LICENSE text.
 */

namespace PHPOrchestra\BlockBundle\Test\IndexCommand;

use Model\PHPOrchestraCMSBundle\Node;
use PHPOrchestra\BlockBundle\IndexCommand\SolrIndexCommand;
use Model\PHPOrchestraCMSBundle\Content;
use Model\PHPOrchestraCMSBundle\FieldIndex;
use PHPOrchestra\CMSBundle\Document\DocumentManager;

/**
 * Unit test of SolrIndexCommand
 * 
 * @author Benjamin Fouché <benjamin.fouche@businessdecision.com>
 *
 */
class SolrIndexCommandTest extends \PHPUnit_Framework_TestCase
{

    /**
     * 
     * @var PHPOrchestra\BlockBundle\IndexCommand\SolrIndexCommand
     */
    protected $solrIndexCommand = null;

    /**
     * 
     * @var Symfony\Component\DependencyInjection\Container
     */
    protected $container = null;
    
    /**
     * 
     * @var Mandango\Mandango
     */
    protected $mandango = null;
    
    /**
     * 
     * @var Solarium\Client
     */
    protected $client = null;
    
    /**
     * 
     * @var PHPOrchestra\CMSBundle\Routing\PhpOrchestraUrlGenerator
     */
    protected $generateUrl = null;


    /**
     * Initialize unit test
     * 
     * @see PHPUnit_Framework_TestCase::setUp()
     */
    public function setUp()
    {
        $this->container = $this->getMock('\\Symfony\\Component\\DependencyInjection\\Container');
        $this->client = $this->getMock('\\Solarium\\Client');
        
        $this->mandango = $this->getMock('PHPOrchestra\\CMSBundle\\Test\\Mock\\Mandango');
        
        $this->generateUrl = $this->getMockBuilder('\\PHPOrchestra\\CMSBundle\\Routing\\PhpOrchestraUrlGenerator')
        ->disableOriginalConstructor()
        ->getMock();
                
        $this->solrIndexCommand = new SolrIndexCommand($this->container);
    }

    
    /**
     * Test the indexation of documents
     */
    public function testIndex()
    {
        $nodes = $this->getNode();
        $fields = SolrIndexCommandTest::getFields();
        
        $document = $this->getMock('\\Solarium\\QueryType\\Update\\Query\\Document');
        $update = $this->getMock('\\Solarium\\QueryType\\Update\\Query\\Query');
        
        $update->expects($this->any())->method('createDocument')->will($this->returnValue($document));
        $this->client->expects($this->once())->method('createUpdate')->will($this->returnValue($update));
        $this->generateUrl->expects($this->any())->method('generate')->will($this->returnValue('/node/nodeId'));
        
        $this->container->expects($this->at(0))->method('get')->will($this->returnValue($this->client));
        $this->container->expects($this->at(1))->method('get')->will($this->returnValue($this->generateUrl));
        $this->container->expects($this->at(2))->method('get')->will($this->returnValue($this->generateUrl));
        
        $result = $this->solrIndexCommand->index($nodes, 'Node', $fields);
        
        $this->assertEquals('', $result);
    }


    /**
     * Test the deletion of an index
     */
    public function testDeleteIndex()
    {
        $update = $this->getMock('\\Solarium\\QueryType\\Update\\Query\\Query');
        
        $this->client->expects($this->once())->method('createUpdate')->will($this->returnValue($update));
        $this->container->expects($this->once())->method('get')->will($this->returnValue($this->client));
        $result = $this->solrIndexCommand->deleteIndex('root');
        $this->assertEquals('', $result);
    }

    
    /**
     * Test get the content of a Node
     */
    public function testGetContentNode()
    {
        $node = new Node($this->mandango);
        $field = '_title';
        
        $result = $this->solrIndexCommand->getContentNode($node, $field);
        
        $this->assertEquals(array(), $result);
    }

    
    /**
     * Test get the content of a Content
     */
    public function testGetContentContent()
    {
        $content = new Content($this->mandango);
        $field = 'title';
        
        $result = $this->solrIndexCommand->getContentContent($content, $field);
        
        $this->assertEquals(array(), $result);
    }


    /**
     * Test get fields with their content
     */
    public function testGetField()
    {
        $expected = array(
            '_title_s' => array(),
            '_news_t' => array(),
            '_author_s' => array(),
            'title_s' => array(),
            'image_s' => array(),
            'intro_t' => array(),
            'text_t' => array(),
            'description_t' => array(),
            'url' => array(0 => '/node/nodeId'),
        );

        $fields = SolrIndexCommandTest::getFields();
        
        $docType = 'Node';
        $doc = new Node($this->mandango);
        $doc->initializeDefaults();
        
        $this->generateUrl->expects($this->any())->method('generate')->will($this->returnValue('/node/nodeId'));
        $this->container->expects($this->any())->method('get')->will($this->returnValue($this->generateUrl));
        
        $result = $this->solrIndexCommand->getField($fields, $doc, $docType);
        $this->assertEquals($expected, $result);
    }


    /**
     * Test splitDoc function
     */
    public function testSplitDoc()
    {
        $fields = SolrIndexCommandTest::getFields();
        
        $fieldIndex = $this->getMock(
            'Model\PHPOrchestraCMSBundle\FieldIndexRepository',
            array(),
            array($this->mandango)
        );
        $fieldIndex->expects($this->once())->method('getAll')->will($this->returnValue($fields));
        $this->mandango->expects($this->once())->method('getRepository')->will($this->returnValue($fieldIndex));
        
        $this->container->expects($this->at(0))->method('get')->will($this->returnValue($this->mandango));
        
        $document = $this->getMock('\\Solarium\\QueryType\\Update\\Query\\Document');
        $update = $this->getMock('\\Solarium\\QueryType\\Update\\Query\\Query');
        
        $update->expects($this->any())->method('createDocument')->will($this->returnValue($document));
        $this->client->expects($this->once())->method('createUpdate')->will($this->returnValue($update));
        
        $this->container->expects($this->at(1))->method('get')->will($this->returnValue($this->client));
        $this->container->expects($this->at(2))->method('get')->will($this->returnValue($this->generateUrl));
        
        $doc = new Node($this->mandango);
        $result = $this->solrIndexCommand->slpitDoc($doc, 'Node');
        
        $this->assertEquals('', $result);
    }


    /**
     * Test testSorlIsRunning function
     */
    public function testSolrIsRunning()
    {
        $request = $this->getMock('\\Solarium\\Core\\Query\\RequestBuilder');
        $ping = $this->getMock('\\Solarium\\QueryType\\Ping\\Query');
        $adapter = $this->getMock('\\Solarium\\Core\\Client\\Adapter\\Curl');
        $endpoint = $this->getMock('\\Solarium\\Core\\Client\\Endpoint');
        
        $this->container->expects($this->once())->method('get')->will($this->returnValue($this->client));
        $this->client->expects($this->at(0))->method('createPing')->will($this->returnValue($ping));
        $this->client->expects($this->at(1))->method('createRequest')->will($this->returnValue($request));
        $adapter->expects($this->once())->method('createHandle')->will($this->returnValue(curl_init()));
        $this->client->expects($this->at(2))->method('getAdapter')->will($this->returnValue($adapter));
        $this->client->expects($this->at(3))->method('getEndPoint')->will($this->returnValue($endpoint));
        
        $this->assertFalse($this->solrIndexCommand->solrIsRunning());
    }


    /**
     * Test generateUrl
     */
    public function testGenerateUrl()
    {
        $repository = $this->getMock(
            'PHPOrchestra\\CMSBundle\\Test\\Mock\\MandangoDocumentRepository',
            array('getAllNodes'),
            array($this->mandango)
        );
        
        $this->mandango->expects($this->any())->method('getRepository')->will($this->returnValue($repository));
        $this->container->expects($this->once())->method('get')->will($this->returnValue($this->mandango));
        
        $result = $this->solrIndexCommand->generateUrl("1", "news");
        $this->assertEquals('', $result);
    }


    /**
     * Create an array of Node
     * 
     * @return multitype:\Model\PHPOrchestraCMSBundle\Node
     */
    public function getNode()
    {
        $documentServices = $this->getMockBuilder('PHPOrchestra\\CMSBundle\\Test\\Mock\\Mandango')
                ->enableProxyingToOriginalMethods()
                ->getMock();
        
        $documentManager = new DocumentManager($documentServices);
        
        $home = $documentManager->createDocument('Node');
        $home->setSiteId(1);
        $home->setLanguage('fr');
        $home->setParentId('superroot');
        
        $full = $documentManager->createDocument('Node');
        $full->setSiteId(1);
        $full->setLanguage('fr');
        $full->setParentId('superroot');
        
        return array($home, $full);
    }


    /**
     * Create an array of FieldIndex
     * 
     * @return multitype:\Model\PHPOrchestraCMSBundle\FieldIndex
     */
    public function getFields()
    {
        $field1 = new FieldIndex($this->mandango);
        $field1->setFieldName('_title');
        $field1->setFieldType('s');
        
        $field2 = new FieldIndex($this->mandango);
        $field2->setFieldName('_news');
        $field2->setFieldType('t');
        
        $field3 = new FieldIndex($this->mandango);
        $field3->setFieldName('_author');
        $field3->setFieldType('s');
        
        $field4 = new FieldIndex($this->mandango);
        $field4->setFieldName('title');
        $field4->setFieldType('s');
        
        $field5 = new FieldIndex($this->mandango);
        $field5->setFieldName('image');
        $field5->setFieldType('s');
        
        $field6 = new FieldIndex($this->mandango);
        $field6->setFieldName('intro');
        $field6->setFieldType('t');
        
        $field7 = new FieldIndex($this->mandango);
        $field7->setFieldName('text');
        $field7->setFieldType('t');
        
        $field8 = new FieldIndex($this->mandango);
        $field8->setFieldName('description');
        $field8->setFieldType('t');
        
        return array(
            0 => $field1,
            1 => $field2,
            2 => $field3,
            3 => $field4,
            4 => $field5,
            5 => $field6,
            6 => $field7,
            7 => $field8
        );
    }
}
