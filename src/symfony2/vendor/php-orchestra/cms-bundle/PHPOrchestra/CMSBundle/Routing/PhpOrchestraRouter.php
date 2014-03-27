<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Noël Gilain <noel.gilain@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Routing;

use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\DependencyInjection\ContainerInterface;

class PhpOrchestraRouter extends Router
{
    protected $mandango = null;
    
    public function __construct(ContainerInterface $container, $resource, array $options = array(), RequestContext $context = null)
    {
        parent::__construct($container, $resource, $options, $context);
        
        $this->mandango = $container->get('mandango');
    }
    
    public function getMatcher()
    {
        if (null !== $this->matcher) {
            return $this->matcher;
        }
        
        return $this->matcher = new $this->options['matcher_class']($this->getRouteCollection(), $this->context, $this->mandango);
    }

}