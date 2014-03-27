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

class PhpOrchestraUrlMatcher extends RedirectableUrlMatcher
{
    protected $mandango = null;

    public function __construct(RouteCollection $routes, RequestContext $context, $mandangoService)
    {
        $this->routes = $routes;
        $this->context = $context;
        $this->mandango = $mandangoService;
    }
    
    
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
    
//    public function matchRequest(Request $request)
//    {
//        return array(
//                   "_controller" => "match2\CMSBundle\Controller\NodeController::showAction",
//                   "nodeId" => "1",
//                   "_route" => "php_orchestra_cms_node"
//        );
//    }
    
    protected function getNode($slug, $parentId)
    {
        $node = DocumentLoader::getDocument('Node', array(), $this->mandango);
        return '';
    }
}
