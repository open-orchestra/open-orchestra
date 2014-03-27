<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Noël Gilain <noel.gilain@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Routing;

use Symfony\Bundle\FrameworkBundle\Routing\RedirectableUrlMatcher;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use PHPOrchestra\CMSBundle\Classes\DocumentLoader;
use PHPOrchestra\CMSBundle\Exception\UnrecognizedDocumentTypeException;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\RequestContext;

/**
 * Dynamic routing based on url
 */
class PhpOrchestraUrlMatcher extends RedirectableUrlMatcher
{
    /**
     * Mandango service
     * @var unknown_type
     */
    protected $mandango = null;
    
    
    /**
     * Constructor
     * 
     * @param RouteCollection $routes
     * @param RequestContext $context
     * @param unknown_type $mandangoService
     */
    public function __construct(RouteCollection $routes, RequestContext $context, $mandangoService)
    {
        $this->routes = $routes;
        $this->context = $context;
        $this->mandango = $mandangoService;
    }
    
    
    /**
     * Find a route for a given url
     * Check first with symfony basic behavior
     * Then if no route found, check with PhpOrchestra logic
     * 
     * @param string $pathinfo
     */
    public function match($pathinfo)
    {
        try {
            $parameters = parent::match($pathinfo);
        } catch (ResourceNotFoundException $e) {            
            $parameters = $this->dynamicMatch($pathinfo);
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
        $nodeId = 0;
        
        foreach ($slugs as $slug) {
            if ($slug != '') {
                $nodeId = $this->getNode($slug, $nodeId);
                
                if (!$nodeId)
                    throw new ResourceNotFoundException();
            }
        }
        
        return array(
                "_controller" => 'PHPOrchestra\CMSBundle\Controller\NodeController::showAction',
                "nodeId" => $nodeId,
                "_route" => "php_orchestra_cms_node"
                );
    }
    
    
    /**
     * Return the nodeId matching slug and parent nodeId
     * 
     * @param string $slug
     * @param string $parentId
     */
    protected function getNode($slug, $parentId)
    {
        $nodeId = false;
        $criteria = array(
                        'parentId' => $parentId,
                        'alias' => $slug
                        );

        $node = DocumentLoader::getDocument('Node', $criteria, $this->mandango);
        
        if (!is_null($node))
            $nodeId = $node->getNodeId();
        
        return $nodeId;
    }
}
