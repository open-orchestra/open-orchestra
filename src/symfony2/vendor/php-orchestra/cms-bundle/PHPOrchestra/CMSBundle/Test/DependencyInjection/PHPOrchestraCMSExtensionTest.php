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

namespace PHPOrchestra\CMSBundle\Test\DependencyInjection;

use \PHPOrchestra\CMSBundle\DependencyInjection\PHPOrchestraCMSExtension;

/**
 * Description of PHPOrchestraCMSExtensionTest
 *
 * @author Nicolas BOUQUET <nicolas.bouquet@businessdecision.com>
 */
class PHPOrchestraCMSExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function testLoad()
    {
        $configs = array();
        
        $container = $this
            ->getMockBuilder('\\Symfony\\Component\\DependencyInjection\\ContainerBuilder')
            ->disableOriginalConstructor()
            ->getMock();
        
        $container
            ->expects($this->exactly(3))
            ->method('addResource')
            ->with($this->isInstanceOf('\\Symfony\\Component\\Config\\Resource\\FileResource'));
        
        $extension = new PHPOrchestraCMSExtension();
        $extension->load($configs, $container);
    }
}
