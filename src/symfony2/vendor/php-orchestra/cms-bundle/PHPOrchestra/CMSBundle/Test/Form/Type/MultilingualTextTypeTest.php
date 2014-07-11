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

use \PHPOrchestra\CMSBundle\Form\Type\MultilingualTextType;

/**
 * Description of ContentTypeTest
 *
 * @author Noël GILAIN <noel.gilain@businessdecision.com>
 */
class MultilingualTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $availableLanguages = array('fr', 'en', 'es');
        
        $container = $this->getMock('\\Symfony\\Component\\DependencyInjection\\ContainerInterface');
        
        $container
            ->expects($this->any())
            ->method('getParameter')
            ->will($this->returnValue($availableLanguages));
        
        $this->multilingualTextTest = new MultilingualTextType($container);
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
            
        $this->multilingualTextTest->buildForm($formBuilderMock, $options);
    }

    public function getOptions()
    {
        return array(
            array(array(), 3),
            array(array('fake' => 'fake'), 3),
            array(array('data' => '{"fr":"français", "de":"deutsch"}'), 3)
        );
    }

    public function testGetName()
    {
        $this->assertEquals('multilingualText', $this->multilingualTextTest->getName());
    }
}
