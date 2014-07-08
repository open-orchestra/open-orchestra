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

namespace PHPOrchestra\CMSBundle\Test\Form\Type;

use \PHPOrchestra\CMSBundle\Form\Type\ContentAttributesType;

/**
 * Description of ContentTypeTest
 *
 * @author Noël GILAIN <noel.gilain@businessdecision.com>
 */
class ContentAttributesTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $documentManager = $this->getMockBuilder('PHPOrchestra\\CMSBundle\\Document\\DocumentManager')
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->contentAttributes = new ContentAttributesType($documentManager);
    }

    /**
     * @dataProvider getOptions
     * 
     * @param array  $options
     * @param int  $expectedAddCount
     */
    public function testBuildForm($options, $expectedAddCount)
    {
        $formBuilderMock =
            $this->getMock('\\Symfony\\Component\\Form\\FormBuilderInterface');
        
        $formBuilderMock
            ->expects($this->exactly($expectedAddCount))
            ->method('add')
            ->will($this->returnSelf());
        
        $this->contentAttributes->buildForm($formBuilderMock, $options);
    }

    public function testGetName()
    {
        $this->assertEquals('contentAttributes', $this->contentAttributes->getName());
    }
    
    public function getOptions()
    {
        /** DATA SET NO FIELD **/
        $contentType0F = $this->getMockBuilder('\\Model\\PHPOrchestraCMSBundle\\ContentType')
            ->disableOriginalConstructor()
            ->getMock();
        $dataWithNoField = (object) array('contentType' => $contentType0F);
        
        /** DATA SET 3 FIELDS **/
        $contentType3F = $this->getMockBuilder('\\Model\\PHPOrchestraCMSBundle\\ContentType')
            ->disableOriginalConstructor()
            ->getMock();
        $jsonFields = '[
            {"fieldId": "field1", "defaultValue": "value1", "label": "label1", "symfonyType": "email"},
            {"fieldId": "field2", "defaultValue": "value2", "label": "label1", "symfonyType": "type2",
             "options": {"max_length": 20, "required": true}},
            {"fieldId": "field3", "defaultValue": "value3",
             "label": "{\"fr\":\"français\", \"en\":\"english\"}", "symfonyType": "type3",
             "options": {"max_length": 0}}
        ]';
        $contentType3F
            ->expects($this->any())
            ->method('getFields')
            ->will($this->returnValue($jsonFields));
        
        $dataWith3Fields = (object) array(
            'contentType' => $contentType3F,
            'language' => 'fr'
        );
        
        return array(
            array(array('data' =>  $dataWithNoField), 0),
            array(array('data' =>  $dataWith3Fields), 3),
        );
    }
}
