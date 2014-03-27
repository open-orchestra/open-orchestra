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

/**
 * The FrameworkBundle router is extended to inject mandango service
 * in PhpOrchestraUrlMatcher
 */
class PhpOrchestraRouter extends Router
{
    /**
     * Mandango service
     * 
     * @var unknown_type
     */
    protected $mandango = null;
    
    /**
     * Extends parent constructor to get mandango service
     * as $container is private in parent class
     *  
     * @param $container
     * @param $resource
     * @param $options
     * @param $context
     */
    public function __construct(ContainerInterface $container, $resource, array $options = array(), RequestContext $context = null)
    {
        parent::__construct($container, $resource, $options, $context);
        
        $this->mandango = $container->get('mandango');
    }
    
    /**
     * Override parent getMatcher to inject mandango service
     * in PhpOrchestraUrlMatcher
     */
    public function getMatcher()
    {
        if (null !== $this->matcher) {
            return $this->matcher;
        }
        
        return $this->matcher = new $this->options['matcher_class']($this->getRouteCollection(), $this->context, $this->mandango);
    }

}