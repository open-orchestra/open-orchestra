<?php

namespace PHPOrchestra\CMSBundle\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;
//use Symfony\Component\HttpKernel;
use Symfony\Component\HttpKernel\Controller\ControllerReference;

class PhpOrchestraExtension extends \Twig_Extension
{
	private $container = null;
	
    public function __construct(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
    
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('render_block', array($this, 'renderBlock'))
        );
    }
    
    public function renderBlock(ControllerReference $controllerReference)
    {
        if ($this->is_callable($controllerReference->controller))
            echo $this->container->get('fragment.handler')->render($controllerReference);
        else
            echo '<span style="background-color:#FF0000">Controller non valide</span><br/>';
    }

    private function is_callable($controller)
    {
    // $controller = 'Bundle:Controller:Action'
    // $class = Bundle\Controller.'Controller'
    // $method = Action . 'Action'
        $status = false;

        list($class, $method) = explode('::', $controller, 2);

$class = "@PHPOrchestraCMSBundle\BlockController";
$method = "showAction";
        
        if ((class_exists($class)) && is_callable(array($class, $method)))
            $status = true;
            
    	return $status;
    }
    
    public function getName()
    {
        return 'orchestra_extension';
    }
}