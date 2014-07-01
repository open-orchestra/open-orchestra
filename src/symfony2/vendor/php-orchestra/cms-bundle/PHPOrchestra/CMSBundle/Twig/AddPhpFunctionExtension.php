<?php
/**
 * This file is part of the PHPOrchestra\ThemeBundle.
 *
 * @author Nicolas ANNE <nicolas.anne@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Twig;
use Symfony\Component\DependencyInjection\ContainerInterface;

class AddPhpFunctionExtension extends \Twig_Extension{
    
    protected $container;
 
    public function __construct(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
	
	/**
     * {@inheritdoc}
     */
    public function getFunctions() {
        return array(
            'file_exists' => new \Twig_Function_Method($this, 'file_exists'),
            'twig_exists' => new \Twig_Function_Method($this, 'twig_exists'),
        );
    }

    public function file_exists($file) {
    	return file_exists($file);
    }
    public function twig_exists($file) {
        return $this->container->get('templating')->exists($file);
    }
    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName() {
        return 'php_function';
    }
}
