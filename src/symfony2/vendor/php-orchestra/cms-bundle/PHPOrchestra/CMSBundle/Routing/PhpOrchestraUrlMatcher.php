<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Noël Gilain <noel.gilain@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Routing;

use Symfony\Bundle\FrameworkBundle\Routing\RedirectableUrlMatcher;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use PHPOrchestra\CMSBundle\Exception\UnrecognizedDocumentTypeException;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\RequestContext;
use Model\PHPOrchestraCMSBundle\Node;

/**
 * Dynamic routing based on url
 */
class PhpOrchestraUrlMatcher extends RedirectableUrlMatcher
{
    /**
     * Prefix for pathinfo cache key
     * @var string
     */
    const PATH_PREFIX = 'router_pathinfo:';

    /**
     * Documents service
     * @var unknown_type
     */
    protected $documentManager = null;

    /**
     * Cache service
     * @var unknown_type
     */
    protected $cacheService = null;


    /**
     * Constructor
     * 
     * @param RouteCollection $routes
     * @param RequestContext $context
     * @param unknown_type $documentManager
     * @param unknown_type $cacheService
     */
    public function __construct(RouteCollection $routes, RequestContext $context, $documentManager, $cacheService)
    {
        $this->routes = $routes;
        $this->context = $context;
        $this->documentManager = $documentManager;
        $this->cacheService = $cacheService;
    }


    /**
     * Find a route for a given url
     * 
     * Check first in cache,
     * Then with symfony basic behavior,
     * and finally with PhpOrchestra logic
     * 
     * @param string $pathinfo
     */
    public function match($pathinfo)
    {
        if ($this->getFromCache($pathinfo)) {
            $parameters = $this->getFromCache($pathinfo);
        } else {
            try {
                $parameters = parent::match($pathinfo);
            } catch (ResourceNotFoundException $e) {
                $parameters = $this->dynamicMatch($pathinfo);
            }
            
            $this->setToCache($pathinfo, $parameters);
        }
        
        return $parameters;
    }


    /**
     * try to find the node via its path
     * 
     * @param string $pathinfo
     * @throws ResourceNotFoundException
     */
    protected function dynamicMatch($pathinfo)
    {
        $slugs = explode('/', $pathinfo);
        $nodeId = Node::ROOT_NODE_ID;
        $moduleId = false;
        $parameters = array();
        
        foreach ($slugs as $position => $slug) {
            
            if ($slug != '') {
                $node = $this->getNode($slug, $nodeId);
                
                if ($node) {
                    $nodeId = $node['id'];
                    
                    if ($node['type'] != Node::TYPE_DEFAULT) {
                        $moduleId = $node['id'];
                        $parameters = array_slice($slugs, $position + 1);
                    } else {
                        $moduleId = false;
                    }
                } else {
                    if ($moduleId) {
                        return $this->getModuleRoute($pathinfo, $moduleId, $parameters);
                    } else {
                        throw new ResourceNotFoundException();
                    }
                }
            }
        }
        
        if ($nodeId == $moduleId) {
            return $this->getModuleRoute($pathinfo, $moduleId);
        } else {
            return $this->getPageRoute($pathinfo, $nodeId);
        }
    }


    /**
     * Get the route parameters from cache if already set
     * 
     * @param string $pathinfo
     */
    protected function getFromCache($pathinfo)
    {
        $parameters = $this->cacheService->get(self::PATH_PREFIX . $pathinfo);
        
        if (isset($parameters['module_parameters'])) {
            $parameters['module_parameters'] = unserialize($parameters['module_parameters']);
        }
        
        return $parameters;
    }


    /**
     * Set route parameters to cache for pathinfo
     * 
     * @param string $pathinfo
     * @param string[] $routeParameters
     */
    protected function setToCache($pathinfo, $routeParameters)
    {
        if (isset($routeParameters['module_parameters'])) {
            $routeParameters['module_parameters'] = serialize($routeParameters['module_parameters']);
        }
        
        return $this->cacheService->set(self::PATH_PREFIX . $pathinfo, $routeParameters);
    }


    /**
     * Route parameters for standard page
     * 
     * @param string $nodeId
     */
    protected function getPageRoute($pathinfo, $nodeId)
    {
        return array(
                     "_route" => "phporchestra_cms_node",
                     "_controller" => 'PHPOrchestra\CMSBundle\Controller\NodeController::showAction',
                     "nodeId" => $nodeId
                    );
    }


    /**
     * Route parameters for module page
     * ie with customs parameters at the end of url
     * 
     * @param string $moduleId
     * @param string[] $moduleId
     */
    protected function getModuleRoute($pathinfo, $moduleId, $parameters = array())
    {
        return array(
                     "_route" => "phporchestra_cms_module",
                     "_controller" => 'PHPOrchestra\CMSBundle\Controller\NodeController::showAction',
                     "nodeId" => $moduleId,
                     "module_parameters" => $parameters
                    );
    }


    /**
     * Return node info related to node matching slug and parent nodeId
     * Info returned are nodeId and NodeType
     * 
     * @param string $slug
     * @param string $parentId
     */
    protected function getNode($slug, $parentId)
    {
        $nodeInfo = false;
        $criteria = array(
            'parentId' => (string)$parentId,
            'alias' => $slug
        );
        
        $node = $this->documentManager->getDocument('Node', $criteria);
        
        if (!is_null($node)) {
            $nodeInfo = array(
                'id' => $node->getNodeId(),
                'type' => $node->getNodeType()
            );
        }
        
        return $nodeInfo;
    }
}
