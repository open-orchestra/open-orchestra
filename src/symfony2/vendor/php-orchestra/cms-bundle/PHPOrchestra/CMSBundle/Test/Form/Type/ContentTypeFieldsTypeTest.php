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

use \PHPOrchestra\CMSBundle\Form\Type\ContentTypeFieldsType;

/**
 * Description of ContentTypeFieldsTypeTest
 *
 * @author Noël GILAIN <noel.gilain@businessdecision.com>
 */
class ContentTypeFieldsTypeTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->ContentTypeFieldsType = new ContentTypeFieldsType();
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
        
        $this->ContentTypeFieldsType->buildForm($formBuilderMock, $options);
    }

    public function testGetName()
    {
        $this->assertEquals('contentTypeFields', $this->ContentTypeFieldsType->getName());
    }
    
    public function getOptions()
    {
        $jsonFields = '[
            {"fieldId": "field1", "defaultValue": "value1", "label": "label1", "symfonyType": "type1"},
            {"fieldId": "field2", "defaultValue": "value2", "label": "label1", "symfonyType": "type2"},
            {"fieldId": "field3", "defaultValue": "value3", "label": "label1", "symfonyType": "type3",
             "options": {"max_length": 0}}
        ]';
        
        return array(
            array(array(), 0),
            array(array('data' =>  ''), 0),
            array(array('data' =>  $jsonFields), 3),
        );
    }
}
