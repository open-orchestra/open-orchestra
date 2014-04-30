<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Noël Gilain <noel.gilain@businessdecision.com>
 */

namespace PHPOrchestra\ThemeBundle\Event\Listener\HttpKernel;

use Symfony\Component\HttpKernel\Event\KernelEvent;
use PHPOrchestra\ThemeBundle\Asset\Package\BundlePathPackage;

class AssetPackageInjector
{

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
