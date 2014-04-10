<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * Based on the work of andrewdevnotes
 * http://andrewdevnotes.blogspot.fr/2013/09/custom-asset-package-for-symfony2-app.html
 * 
 * @author Noël Gilain <noel.gilain@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Asset\Package;

use Symfony\Component\Templating\Asset\PathPackage;

/**
 * Alternative package for assets
 * Give the location of an asset from a bundle
 * 
 * @author Noël
 */
class BundlePathPackage extends PathPackage
{
    /**
     * Bundle assets web directory
     *
     * @var string
     */
    private $bundleDir;

    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Templating\Asset\PathPackage::getUrl
     */
    public function getUrl($path)
    {
        if (isset($this->bundleDir)) {
            $path = $this->bundleDir . '/' . ltrim($path, '/');
        }
        
        return parent::getUrl($path);
    }

    /**
     * Set the bundle assets web path according to the bundle name
     * 
     * @param string $bundleName
     */
    public function setBundlePath($bundleName)
    {
        $this->bundleDir = 'bundles/' . strtolower(str_replace('Bundle', '', $bundleName));
    }
}
