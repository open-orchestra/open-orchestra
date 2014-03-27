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
            $this->getNode('/', 0);
            die('Pas trouvé dans le parent');
        }
        
        return $parameters;
    }
    
    /**
     * Return the nodeId matching slug and parent nodeId
     * 
     * @param string $slug
     * @param string $parentId
     */
    protected function getNode($slug, $parentId)
    {
        $node = DocumentLoader::getDocument('Node', array(), $this->mandango);
        return '';
    }
}
