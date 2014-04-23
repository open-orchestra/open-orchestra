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

namespace PHPOrchestra\CMSBundle\Test\Document;

use PHPOrchestra\CMSBundle\Document\DocumentLoader;

/**
 * Unit tests of DocumentLoader
 *
 * @author Nicolas BOUQUET <nicolas.bouquet@businessdecision.com>
 */
class DocumentLoaderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * DocumentLoader to be tested
     *
     * @var PHPOrchestra\CMSBundle\Document\DocumentLoader
     */
    protected $documentLoader = null;
    
    /**
     * Database mock system
     * 
     * @var \PHPOrchestra\CMSBundle\Test\Mock\Mandango
     */
    protected $documentService = null;

    /**
     * Tests setup
     */
    public function setUp()
    {
        $this->documentService = $this->getMockBuilder('PHPOrchestra\\CMSBundle\\Test\\Mock\\Mandango')
                ->enableProxyingToOriginalMethods()
                ->getMock();
        
        
        $this->documentService->setDB(
            array(
                'Model\PHPOrchestraCMSBundle\Node' => array(
                    1 => array(
                        '_id'       => 'a01',
                        'node_id'   => 'a01',
                        'parent_id' => 0,
                        'alias'     => 'test1',
                        'node_type' => 'page'
                    ),
                    2 => array(
                        '_id'       => 'a02',
                        'node_id'   => 'a02',
                        'parent_id' => 0,
                        'alias'     => 'test2',
                        'node_type' => 'page'
                    ),
                    3 => array(
                        '_id'       => 'a03',
                        'node_id'   => 'a03',
                        'parent_id' => 0,
                        'alias'     => 'test3',
                        'node_type' => 'page'
                    ),
                ),
                'Model\PHPOrchestraCMSBundle\Template' => array(
                    1 => array(
                        '_id'       => 'b01',
                        'template_id' => 'b01',
                        'parent_id' => 0,
                        'alias'     => 'test1',
                        'node_type' => 'page'
                    ),
                    2 => array(
                        '_id'       => 'b02',
                        'template_id' => 'b02',
                        'parent_id' => 0,
                        'alias'     => 'test2',
                        'node_type' => 'page'
                    ),
                    3 => array(
                        '_id'       => 'b03',
                        'template_id' => 'b03',
                        'parent_id' => 0,
                        'alias'     => 'test3',
                        'node_type' => 'page'
                    ),
                )
            )
        );
        
        $this->documentLoader = new DocumentLoader($this->documentService);
    }
    
    /**
     * @dataProvider createDocumentData
     * @param string $nodeType
     */
    public function testCreateDocument($expectedClass, $documentType)
    {
        $document = $this->documentLoader->createDocument($documentType);
        
        $this->assertInstanceOf($expectedClass, $document);
    }
    
    /**
     * @expectedException \PHPOrchestra\CMSBundle\Exception\UnrecognizedDocumentTypeException
     * @param string $nodeType
     */
    public function testCreateDocumentException()
    {
        $this->documentLoader->createDocument('BadDocumentType');
    }
    
    /**
     * @dataProvider getDocumentData
     * @param string $expectedDocumentId
     * @param string $documentType
     * @param array  $criteria
     */
    public function testGetDocument($expectedDocumentId, $documentType, $criteria)
    {
        $document = $this->documentLoader->getDocument($documentType, $criteria);
        
        $this->assertEquals($expectedDocumentId, $document->getId());
    }
    
    /**
     * @expectedException \PHPOrchestra\CMSBundle\Exception\UnrecognizedDocumentTypeException
     * @param string $nodeType
     */
    public function testGetDocumentException()
    {
        $this->documentLoader->getDocument('BadDocumentType');
    }
    
    public function testGetNodesInLastVersion()
    {
        $nodes = $this->documentLoader->getNodesInLastVersion();
        
        $this->assertEquals('a01', $nodes[1]['node_id']);
        $this->assertEquals('a02', $nodes[2]['node_id']);
        $this->assertEquals('a03', $nodes[3]['node_id']);
    }
    
    public function testGetTemplatesInLastVersion()
    {
        $templates = $this->documentLoader->getTemplatesInLastVersion();
        
        $this->assertEquals('b01', $templates[1]['template_id']);
        $this->assertEquals('b02', $templates[2]['template_id']);
        $this->assertEquals('b03', $templates[3]['template_id']);
    }
    
    public function createDocumentData()
    {
        return array(
            array('Model\PHPOrchestraCMSBundle\Node',     'Node'),
            array('Model\PHPOrchestraCMSBundle\Template', 'Template'),
            array('Model\PHPOrchestraCMSBundle\Block',    'Block'),
        );
    }
    
    public function getDocumentData()
    {
        return array(
            array('a02', 'Node',     array('alias' => 'test2')),
            array('b01', 'Template', array()),
        );
    }
}
