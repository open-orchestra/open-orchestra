<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Noël Gilain <noel.gilain@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Controller\ControllerReference;

class PhpOrchestraExtension extends \Twig_Extension
{

    /**
     * Services container
     * @var ContainerInterface
     */
    private $container = null;
    
    /**
     * Extension constructor requires service container
     * 
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
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
            new \Twig_SimpleFunction('render_block', array($this, 'renderBlock'))
        );
    }
    
    /**
     * This twig function render a controller action, only if it is callable
     * 
     * @param ControllerReference $controllerReference
     */
    public function renderBlock(ControllerReference $controllerReference)
    {
        if ($this->is_callable($controllerReference->controller))
            return $this->container->get('fragment.handler')->render($controllerReference);
        else
            return '<span style="background-color:#FF0000">Controller non valide</span><br/>';
    }

    /**
     * Check if an action of a controller is callable
     * 
     * @param string $actionLogicalName
     */
    private function is_callable($actionLogicalName)
    {
        $status = false;
        list($bundleName, $controllerName, $actionName) = explode(':', $actionLogicalName, 3);
        
        $bundle = $this->container->get('kernel')->getBundle($bundleName);
        $class = $bundle->getNamespace() . '\\Controller\\'. $controllerName . 'Controller';
        
        if ((class_exists($class)) && is_callable(array($class, $actionName . 'Action')))
            $status = true;
        
        return $status;
    }
    
    /**
     * (non-PHPdoc)
     * @see src/symfony2/vendor/twig/twig/lib/Twig/Twig_ExtensionInterface::getName()
     */
    public function getName()
    {
        return 'orchestra_extension';
    }
}