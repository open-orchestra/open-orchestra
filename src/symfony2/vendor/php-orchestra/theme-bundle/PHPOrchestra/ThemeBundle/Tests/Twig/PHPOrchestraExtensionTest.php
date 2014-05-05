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

namespace PHPOrchestra\ThemeBundle\Test\Twig;

use \PHPOrchestra\ThemeBundle\Twig\PHPOrchestraExtension;

/**
 * Unit tests of PHPOrchestraExtension
 *
 * @author Nicolas BOUQUET <nicolas.bouquet@businessdecision.com>
 */
class PHPOrchestraExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->container = $this->getMock('\\Symfony\\Component\\DependencyInjection\\ContainerInterface');
        $this->extension = new PHPOrchestraExtension($this->container);
    }
    
    public function testGetFunctions()
    {
        $functions = $this->extension->getFunctions();
        
        $this->assertCount(2, $functions);
        $this->assertContainsOnlyInstancesOf(
            '\\Twig_SimpleFunction',
            $functions
        );
    }
    
    public function testPhpOrchestraCssTheme()
    {
        // TODO
    }
    
    public function testPhpOrchestraJsTheme()
    {
        // TODO
    }
    
    public function testGetName()
    {
        $this->assertEquals(
            'phporchestra_extension',
            $this->extension->getName()
        );
    }
}
