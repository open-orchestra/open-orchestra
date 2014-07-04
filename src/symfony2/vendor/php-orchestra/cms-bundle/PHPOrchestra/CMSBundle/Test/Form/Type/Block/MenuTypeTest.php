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

namespace PHPOrchestra\CMSBundle\Test\Form\Type\Block;

use \PHPOrchestra\CMSBundle\Form\Type\Block\MenuType;

/**
 * Test unit of MenuType
 *
 * @author Benjamin Fouché <benjamin.fouche@businessdecision.com>
 *
 */
class MenuTypeTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->menuType = new MenuType();
    }


    public function testBuildForm()
    {
        $formBuilderMock =
        $this->getMock('\\Symfony\\Component\\Form\\FormBuilderInterface');
         
        $formBuilderMock
            ->expects($this->exactly(2))
            ->method('add')
            ->will($this->returnSelf());
        
        $this->menuType->buildForm($formBuilderMock, array());
    }
}
