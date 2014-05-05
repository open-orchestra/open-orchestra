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

namespace PHPOrchestra\ThemeBundle\Test\Event\Listener\HttpKernel;

use \PHPOrchestra\ThemeBundle\Event\Listener\HttpKernel\AssetPackageInjector;

/**
 * Description of AssetPackageInjectorTest
 *
 * @author Nicolas BOUQUET <nicolas.bouquet@businessdecision.com>
 */
class AssetPackageInjectorTest extends \PHPUnit_Framework_TestCase
{
    public function testOnKernelRequest()
    {
        $assetsHelper = $this->getMockBuilder('\\Symfony\\Component\\Templating\\Helper\\CoreAssetsHelper')
            ->disableOriginalConstructor()
            ->getMock();
        
        $assetsHelper->expects($this->any())
            ->method('addPackage')
            ->with(
                $this->equalTo('bundleName'),
                $this->isInstanceOf('\\PHPOrchestra\\ThemeBundle\\Asset\\Package\\BundlePathPackage')
            );
        
        $bundles = array();
        
        $bundle = $this->getMock('\\Symfony\\Component\\HttpKernel\\Bundle\\BundleInterface');
        $bundle->expects($this->exactly(2))
            ->method('getName')
            ->will($this->returnValue('bundleName'));
        
        $bundles[] = $bundle;
        
        $kernel = $this->getMock('\\Symfony\\Component\\HttpKernel\\KernelInterface');
        $kernel->expects($this->once())
            ->method('getBundles')
            ->will($this->returnValue($bundles));
        
        $container = $this->getMock('\\Symfony\\Component\\DependencyInjection\\Container');
        
        $container->expects($this->at(0))
            ->method('get')
            ->with($this->equalTo('templating.helper.assets'))
            ->will($this->returnValue($assetsHelper));
        
        $container->expects($this->at(1))
            ->method('get')
            ->with($this->equalTo('kernel'))
            ->will($this->returnValue($kernel));
        
        $dispatcher = new \Symfony\Component\EventDispatcher\ContainerAwareEventDispatcher($container);
        
        $event = $this->getMockBuilder('\\Symfony\\Component\\HttpKernel\\Event\\KernelEvent')
            ->disableOriginalConstructor()
            ->getMock();
        
        $event->expects($this->once())
            ->method('getDispatcher')
            ->will($this->returnValue($dispatcher));
        
        $assetPackageInjector = new AssetPackageInjector();
        $assetPackageInjector->onKernelRequest($event);
        
        
    }
    /**
     * Inject custom Asset package to Kernel assets helper
     * 
     * @param \Symfony\Component\HttpKernel\Event\KernelEvent $event
     */
    public function onKernelRequest(KernelEvent $event)
    {
        $container = $event->getDispatcher()->getContainer();
        
        $assetsHelper = $container->get('templating.helper.assets');
        
        $bundles = $container->get('kernel')->getBundles();
        
        foreach ($bundles as $bundle) {
            $bundlePathPackage = new BundlePathPackage();
            $bundlePathPackage->setBundlePath($bundle->getName());
            $assetsHelper->addPackage($bundle->getName(), $bundlePathPackage);
        }
    }
}
