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

use \PHPOrchestra\CMSBundle\Form\Type\ContentType;

/**
 * Description of ContentTypeTest
 *
 * @author Noël GILAIN <noel.gilain@businessdecision.com>
 */
class ContentTypeTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $contextManager = $this->getMockBuilder('\\PHPOrchestra\\CMSBundle\\Context\\ContextManager')
            ->disableOriginalConstructor()
            ->getMock();
        
        $contextManager->expects($this->any())
            ->method('getCurrentLocale')
            ->will($this->returnValue('en'));
        
        $this->contentType = new ContentType($contextManager);
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
        $this->contentType->buildForm($formBuilderMock, $options);
    }

    public function getOptions()
    {
        $contentType = $this->getMockBuilder('\\Model\\PHPOrchestraCMSBundle\\Content')
            ->disableOriginalConstructor()
            ->getMock();
        $contentTypeFull = $this->getMockBuilder('\\Model\\PHPOrchestraCMSBundle\\Content')
            ->disableOriginalConstructor()
            ->getMock();
        $contentTypeFull->contentTypeStructure = 'fakeStructure';
        
        $contentTypeFull->expects($this->any())
            ->method('getAttributes')
            ->will($this->returnValue((object) array('fakeAttribute' => 'fakeValue')));
        
        return array(
            array(array(), 6),
            array(array('data' => 'fake'), 6),
            array(array('data' =>  $contentType), 7),
            array(array('data' =>  $contentTypeFull), 8)
        );
    }

    public function testGetName()
    {
        $this->assertEquals('content', $this->contentType->getName());
    }
}
