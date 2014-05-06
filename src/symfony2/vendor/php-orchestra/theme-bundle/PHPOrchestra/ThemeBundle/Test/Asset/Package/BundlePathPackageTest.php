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

namespace PHPOrchestra\ThemeBundle\Test\Asset\Package;

use \PHPOrchestra\ThemeBundle\Asset\Package\BundlePathPackage;

/**
 * Unit tests of BundlePathPackage
 *
 * @author Nicolas BOUQUET <nicolas.bouquet@businessdecision.com>
 */
class BundlePathPackageTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->bundlePathPackage = new BundlePathPackage();
    }
    
    /**
     * Test BundlePathPackage::getUrl
     * 
     * @dataProvider getUrlData
     * 
     * @param string $expectedUrl
     * @param string $bundle
     * @param string $path
     */
    public function testGetUrl($expectedUrl, $bundle, $path)
    {
        if (isset($bundle)) {
            $this->bundlePathPackage->setBundlePath($bundle);
        }
        $resultURL = $this->bundlePathPackage->getUrl($path);
        
        $this->assertEquals($expectedUrl, $resultURL);
    }
    
    /**
     * Test BundlePathPackage::SetBundlePath
     * 
     * @dataProvider setBundlePathData
     * 
     * @param string $expectedBundlePath
     * @param string $bundle
     */
    public function testSetBundlePath($expectedBundlePath, $bundle)
    {
        $this->bundlePathPackage->setBundlePath($bundle);
        
        $this->assertEquals(
            $expectedBundlePath,
            $this->bundlePathPackage->getBundleDir()
        );
    }
    
    /**
     * Data provider for getUrl
     * @return array
     */
    public function getUrlData()
    {
        return array(
            array('/bundles/dummy/some/path',          'DummyBundle', '/some/path'),
            array('/some/path',                        null,          '/some/path'),
            array('/bundles/dummy/other/path/longer/', 'DummyBundle', 'other/path/longer/'),
            array('/other/path/longer/',               null,          'other/path/longer/'),
        );
    }
    
    /**
     * Data provider for setBundlePath
     * @return array
     */
    public function setBundlePathData()
    {
        return array(
            array('bundles/example',            'ExampleBundle'),
            array('bundles/longnamewithsuffix', 'LongNameWithSuffixBundle'),
            array('bundles/withoutsuffix',      'WithoutSuffix'),
            
            // TODO: this should raise exceptions
            array('bundles/', ''),
            array('bundles/double', 'DoubleBundleBundle'),
        );
    }
}
