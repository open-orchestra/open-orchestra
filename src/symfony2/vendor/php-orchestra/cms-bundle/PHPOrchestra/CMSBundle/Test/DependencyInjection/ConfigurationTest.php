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

use \PHPOrchestra\CMSBundle\DependencyInjection\Configuration;

/**
 * Description of ConfigurationTest
 *
 * @author Nicolas BOUQUET <nicolas.bouquet@businessdecision.com>
 */
class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    public function testGetConfigTreeBuilder()
    {
        $configuration = new Configuration();
        $treebuilder   = $configuration->getConfigTreeBuilder();
        
        $this->assertInstanceOf(
            '\\Symfony\\Component\\Config\\Definition\\Builder\\TreeBuilder',
            $treebuilder
        );
    }
}
