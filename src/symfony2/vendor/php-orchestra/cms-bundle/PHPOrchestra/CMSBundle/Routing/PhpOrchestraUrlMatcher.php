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
use Model\PHPOrchestraCMSBundle\Node;

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
        try
        {
            $parameters = parent::match($pathinfo);
        }
        catch (ResourceNotFoundException $e)
        {            
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
                    }
                    else
                        $moduleId = false;
                }
                else {
                    if ($moduleId)
                        return $this->getModuleRoute($moduleId, $parameters);
                    else
                        throw new ResourceNotFoundException();
                }
            }
        }
        
        if ($nodeId == $moduleId)
            return $this->getModuleRoute($moduleId);
        else
            return $this->getPageRoute($nodeId);
    }
    
    
    /**
     * Route for standard page
     * 
     * @param string $nodeId
     */
    protected function getPageRoute($nodeId)
    {
        return array(
                        "_route" => "phporchestra_cms_node",
                        "_controller" => 'PHPOrchestra\CMSBundle\Controller\NodeController::showAction',
                        "nodeId" => $nodeId
                    );
    }
    
    
    /**
     * Route for module page
     * ie with customs parameters at the end of url
     * 
     * @param string $moduleId
     * @param string[] $moduleId
     */
    protected function getModuleRoute($moduleId, $parameters = array())
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
        
        $node = DocumentLoader::getDocument('Node', $criteria, $this->mandango);
        
        if (!is_null($node))
            $nodeInfo = array(
                                'id' => $node->getNodeId(),
                                'type' => $node->getNodeType()
                             );
        
        return $nodeInfo;
    }
}
