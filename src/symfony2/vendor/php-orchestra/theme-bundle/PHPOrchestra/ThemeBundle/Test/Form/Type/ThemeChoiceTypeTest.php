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

namespace PHPOrchestra\ThemeBundle\Test\Form\Type;

use \PHPOrchestra\ThemeBundle\Form\Type\ThemeChoiceType;
use \PHPOrchestra\CMSBundle\Test\Mock;

/**
 * Description of ThemeChoiceTypeTest
 *
 * @author Nicolas BOUQUET <nicolas.bouquet@businessdecision.com>
 */
class ThemeChoiceTypeTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        
        $themes = array(
            'themeId1' => array('name' => 'Dummy theme #1'),
            'themeId2' => array('name' => 'Dummy theme #2'),
        );
        
        $this->themeChoiceType = new ThemeChoiceType($themes);
    }
    
    public function testSetDefaultOptions()
    {
        $choices = array(
            'themeId1' => 'Dummy theme #1',
            'themeId2' => 'Dummy theme #2',
        );
        
        $resolverMock =
            $this->getMock('\\Symfony\\Component\\OptionsResolver\\OptionsResolverInterface');
        
        $resolverMock
            ->expects($this->once())
            ->method('setDefaults')
            ->with($this->equalTo(array('choices' => $choices)));
        
        $this->themeChoiceType->setDefaultOptions($resolverMock);
    }
    
    public function testGetParent()
    {
        $this->assertEquals('choice', $this->themeChoiceType->getParent());
    }

    public function testGetName()
    {
        $this->assertEquals('orchestra_theme_choice', $this->themeChoiceType->getName());
    }
}
