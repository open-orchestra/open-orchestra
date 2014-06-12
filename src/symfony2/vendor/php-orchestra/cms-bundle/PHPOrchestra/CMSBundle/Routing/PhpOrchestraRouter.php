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
 * The FrameworkBundle router is extended to inject documents service
 * in PhpOrchestraUrlMatcher
 */
class PhpOrchestraRouter extends Router
{
    /**
     * Documents service
     * 
     * @var unknown_type
     */
    protected $documentManager = null;
    
    /**
     * Cache service
     * 
     * @var unknown_type
     */
    protected $cacheService = null;
    
    /**
     * Extends parent constructor to get documents service
     * as $container is private in parent class
     *  
     * @param $container
     * @param $resource
     * @param $options
     * @param $context
     */
    public function __construct(
        ContainerInterface $container,
        $resource,
        array $options = array(),
        RequestContext $context = null
    ) {
        parent::__construct($container, $resource, $options, $context);
        
        $this->documentManager = $container->get('phporchestra_cms.documentmanager');
        $this->cacheService = $container->get('phporchestra_cms.cachemanager');
    }
    
    /**
     * Override parent getMatcher to inject documents service
     * in PhpOrchestraUrlMatcher
     */
    public function getMatcher()
    {
        if (null !== $this->matcher) {
            return $this->matcher;
        }
        
        return $this->matcher = new $this->options['matcher_class'](
            $this->getRouteCollection(),
            $this->context,
            $this->documentManager,
            $this->cacheService
        );
    }
    
    /**
     * Get the url generator
     */
    public function getGenerator()
    {
        if (null !== $this->generator) {
            return $this->generator;
        }
        
        return $this->generator = new $this->options['generator_class'](
            $this->getRouteCollection(),
            $this->context,
            $this->documentManager,
            $this->logger
        );
    }
}
