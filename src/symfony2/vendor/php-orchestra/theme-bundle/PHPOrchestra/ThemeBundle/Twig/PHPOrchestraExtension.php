<?php
/**
 * This file is part of the PHPOrchestra\ThemeBundle.
 *
 * @author Noël Gilain <noel.gilain@businessdecision.com>
 */

namespace PHPOrchestra\ThemeBundle\Twig;

class PHPOrchestraExtension extends \Twig_Extension
{
    const FILETYPE_CSS = 'stylesheet';
    const FILETYPE_JS = 'javascript';
    
    private $container;
    private $themes;
    
    /**
     * Constructor
     * 
     * @param $container
     */
    public function __construct($container)
    {
        $this->container = $container;
        $this->themes = $this->container->getParameter('php_orchestra_theme.themes');
    }

    /**
     * (non-PHPdoc)
     * @see src/symfony2/vendor/twig/twig/lib/Twig/Twig_Extension::getFunctions()
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction(
                'phpOrchestraCss',
                array($this, 'phpOrchestraCss'),
                array('is_safe' => array('html'))
            ),
            new \Twig_SimpleFunction(
                'phpOrchestraJs',
                array($this, 'phpOrchestraJs'),
                array('is_safe' => array('html'))
            )
        );
    }

    /**
     * Return the html tags including the css from the theme
     * 
     * @param string themeId
     */
    public function phpOrchestraCss($themeId)
    {
        $tags = '';
        
        if (isset($this->themes[$themeId]) && isset($this->themes[$themeId]['stylesheets'])) {
            $stylesheets = $this->themes[$themeId]['stylesheets'];
            foreach ($stylesheets as $stylesheet) {
                $tags .= $this->getHtmlTag($stylesheet, self::FILETYPE_CSS);
            }
        }
        
        return $tags;
    }

     /**
     * Return the html tags to include js files from the theme
     * 
     * @param string themeId
     */
    public function phpOrchestraJs($themeId)
    {
        $tags = '';
        
        if (isset($this->themes[$themeId]) && isset($this->themes[$themeId]['javascripts'])) {
            $javascripts = $this->themes[$themeId]['javascripts'];
            foreach ($javascripts as $javascript) {
                $tags .= $this->getHtmlTag($javascript, self::FILETYPE_JS);
            }
        }
        
        return $tags;
    }

    /**
     * Generate html tag for a javascript or stylesheet asset
     * 
     * @param string $file (bundleName:themeName:subpathToFile)
     * @param string $fileType
     */
    protected function getHtmlTag($file, $fileType)
    {
        list($bundleName, $themeName, $filePath) = explode(':', $file);
        
        $assetsPath = $this->container->get('templating.helper.assets')->getUrl('', $bundleName);
        $themePath = 'themes' . DIRECTORY_SEPARATOR . $themeName;
        $filePath = $assetsPath . $themePath . DIRECTORY_SEPARATOR . $filePath;
        
        switch ($fileType) {
            case self::FILETYPE_CSS:
                $tag = '<link type="text/css" rel="stylesheet" href="' . $filePath . '">' . PHP_EOL;
                break;
            case self::FILETYPE_JS:
                $tag = '<script type="text/javascript" src="' . $filePath . '"></script>' . PHP_EOL;
                break;
            default:
                $tag = '';
        }
        
        return $tag;
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
