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
        $this->container->expects($this->any())
                        ->method('getParameter')
                        ->will($this->returnValue($this->getFakeThemes()));
                        
        $this->container->expects($this->any())
                        ->method('get')
                        ->will($this->returnValue(NULL));
                        
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
    
    /**
     * Test PHPOrchestraExtension::phpOrchestraCss
     * 
     * @dataProvider phpOrchestraCssData
     * 
     * @param string $themeId
     * @param string $expectedTag
     */
    public function testPhpOrchestraCss($themeId, $expectedTag)
    {
        $this->assertEquals(
            $expectedTag,
            $this->extension->phpOrchestraCss($themeId)
        );
    }
    
    public function testPhpOrchestraJs()
    {
        // TODO
    }
    
    public function testGetHtmlTag()
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
    
    /**
     * Data provider for phpOrchestraCss
     * @return array
     */
    public function phpOrchestraCssData()
    {;
    
        $ds = DIRECTORY_SEPARATOR;
        return array(
         /*   array('jsTheme', '<script type="text/javascript" src="themes' . $ds . 'jsTheme' . $ds . 'pathToFile1.js"></script>' . PHP_EOL),
            array('cssTheme', '<link type="text/css" rel="stylesheet" href="themes' . $ds . 'cssTheme' . $ds . 'pathToFile1.css">' . PHP_EOL),
        */    array('unknownTheme', ''),
            
        );
    }
    
    public function getFakeThemes()
    {
        return array(
            'jsTheme' => array(
                'name' => 'Thème JS',
                'javascripts' => array('someBundle:themeJS:pathToFile1.js')
            ),
            'cssTheme' => array(
                'name' => 'Thème CSS',
                'stylesheets' => array('otherBundle:themeCSS:pathToFile1.css')
            )
        );
    }
}
