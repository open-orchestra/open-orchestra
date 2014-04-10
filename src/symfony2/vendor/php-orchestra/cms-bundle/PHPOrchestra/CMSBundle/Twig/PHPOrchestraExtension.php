<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Noël Gilain <noel.gilain@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Twig;

class PHPOrchestraExtension extends \Twig_Extension
{
    private $container;

    /**
     * Constructor
     * 
     * @param $container
     */
    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * (non-PHPdoc)
     * @see src/symfony2/vendor/twig/twig/lib/Twig/Twig_Extension::getFunctions()
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction(
                'phpOrchestraTheme',
                array($this, 'phpOrchestraTheme'),
                array('is_safe' => array('html'))
            ),
            new \Twig_SimpleFunction(
                'phpOrchestraImageTheme',
                array($this, 'phpOrchestraImageTheme'),
                array('is_safe' => array('html'))
            ),
        );
    }

    /**
     * Return the html tags including the css and js from the theme
     * 
     * @param string $theme (bundleName:themeName)
     */
    public function phpOrchestraTheme($theme)
    {
        $theme = explode(':', $theme);
        
        $assetsPath = $this->container->get('templating.helper.assets')->getUrl('', $theme[0]);
        $cssPath = $assetsPath . 'themes' . DIRECTORY_SEPARATOR . $theme[1] . DIRECTORY_SEPARATOR . 'css';
        $jsPath = $assetsPath . 'themes' . DIRECTORY_SEPARATOR . $theme[1] . DIRECTORY_SEPARATOR . 'js';
        
        $tags = $this->getCssTags($cssPath);
        $tags .= $this->getJsTags($jsPath);
        
        return $tags;
    }

    /**
     * Return the css tag for the master css files located at $path
     * 
     * @param string $path
     */
    protected function getCssTags($path)
    {
        return '<link type="text/css" rel="stylesheet" href="' . $path . DIRECTORY_SEPARATOR . 'master.css">' . PHP_EOL;
    }

    /**
     * Return the js tags for all css files located at $path
     * @param $path
     */
    protected function getJsTags($path)
    {
        $tags = '';
        $webDir = getcwd();
        
        foreach (glob($webDir . $path . DIRECTORY_SEPARATOR . "*.js") as $filename) {
            $tags .= '<script type="text/javascript" src="'
                . str_replace($webDir, '', $filename) . '"></script>' . PHP_EOL;
        }
        
        return $tags;
    }

    /**
     * (non-PHPdoc)
     * @see src/symfony2/vendor/twig/twig/lib/Twig/Twig_ExtensionInterface::getName()
     */
    public function getName()
    {
        return 'phporchestra_extension';
    }
}
