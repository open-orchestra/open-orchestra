<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * Based on the work of andrewdevnotes - http://andrewdevnotes.blogspot.fr/2013/09/custom-asset-package-for-symfony2-app.html
 * 
 * @author Noël Gilain <noel.gilain@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Asset\Package;

use Symfony\Component\Templating\Asset\PathPackage;

class BundlePathPackage extends PathPackage
{
    private $bundleDir;

    public function getUrl($path)
    {
        if (isset($this->bundleDir))
            $path = $this->bundleDir . '/' . ltrim($path, '/');
        
        return parent::getUrl($path);
    }

    public function setBundlePath($bundleName)
    {
        $this->bundleDir = 'bundles/' . strtolower(str_replace('Bundle', '', $bundleName));
    }

} 