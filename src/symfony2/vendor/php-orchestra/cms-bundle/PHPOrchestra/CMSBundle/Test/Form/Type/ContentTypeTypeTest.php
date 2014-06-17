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

use \PHPOrchestra\CMSBundle\Form\Type\ContentTypeType;

/**
 * Description of ContentTypeTest
 *
 * @author Noël GILAIN <noel.gilain@businessdecision.com>
 */
class ContentTypeTypeTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->contentTypeType = new ContentTypeType();
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
        
        $this->contentTypeType->buildForm($formBuilderMock, $options);
    }

    public function testGetName()
    {
        $this->assertEquals('contentType', $this->contentTypeType->getName());
    }
    
    public function getOptions()
    {
        $contentTypeWithNoField = $this->getMockBuilder('\\Model\\PHPOrchestraCMSBundle\\ContentType')
            ->disableOriginalConstructor()
            ->getMock();
        
        $contentTypeWithNoField
            ->expects($this->any())
            ->method('getId')
            ->will($this->returnValue('id'));
        
        
        
        $contentTypeWith3Fields = $this->getMockBuilder('\\Model\\PHPOrchestraCMSBundle\\ContentType')
            ->disableOriginalConstructor()
            ->getMock();
        
        $jsonFields = '[
            {"fieldId": "field1", "defaultValue": "value1", "label": "label1", "symfonyType": "type1"},
            {"fieldId": "field2", "defaultValue": "value2", "label": "label1", "symfonyType": "type2"},
            {"fieldId": "field3", "defaultValue": "value3", "label": "label1", "symfonyType": "type3", "options": {"max_length": 0}}
        ]';
        
        $contentTypeWith3Fields
            ->expects($this->any())
            ->method('getId')
            ->will($this->returnValue('id'));
        
        $contentTypeWith3Fields
            ->expects($this->any())
            ->method('getId')
            ->will($this->returnValue('id'));
        
        $contentTypeWith3Fields
            ->expects($this->any())
            ->method('getFields')
            ->will($this->returnValue($jsonFields));
        
        
        
        return array(
            array(array('data' =>  $contentTypeWithNoField), 7),
            array(array('data' =>  $contentTypeWith3Fields), 10),
        );
    }
}
