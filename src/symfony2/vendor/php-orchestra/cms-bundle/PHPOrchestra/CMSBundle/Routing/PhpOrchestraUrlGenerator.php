<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Noël Gilain <noel.gilain@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Routing;

use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Model\PHPOrchestraCMSBundle\Node;

class PhpOrchestraUrlGenerator extends UrlGenerator
{
    /**
     * Documents service
     * @var unknown_type
     */
    protected $documentManager = null;


    /**
     * Constructor
     * 
     * @param RouteCollection $routes
     * @param RequestContext $context
     * @param unknown_type $documentManager
     * @param LoggerInterface $logger
     */
    public function __construct(
        RouteCollection $routes,
        RequestContext $context,
        $documentManager,
        LoggerInterface $logger = null
    ) {
        $this->routes = $routes;
        $this->context = $context;
        $this->logger = $logger;
        $this->documentManager = $documentManager;
    }

    /**
     * (non-PHPdoc)
     * @see src/symfony2/vendor/symfony/symfony/src/Symfony/Component/Routing/Generator/Symfony
     * \Component\Routing\Generator.UrlGenerator::generate()
     */
    public function generate($name, $parameters = array(), $referenceType = self::ABSOLUTE_PATH)
    {
        try {
            $uri = parent::generate($name, $parameters, $referenceType);
        } catch (RouteNotFoundException $e) {
            $uri = $this->dynamicGenerate($name, $parameters, $referenceType);
        }
        return $uri;
    }

    /**
     * Generate url for a PHPOrchestra node
     * 
     * @param string $nodeId
     * @param array $parameters
     * @param string $referenceType
     */
    protected function dynamicGenerate($nodeId, $parameters, $referenceType)
    {
        $schemeAuthority = '';
        $url = $this->getNodeAlias($nodeId);
        $scheme = $this->context->getScheme();
        $host = $this->context->getHost();
        
        if (self::ABSOLUTE_URL === $referenceType || self::NETWORK_PATH === $referenceType) {
            $port = '';
            if ('http' === $scheme && 80 != $this->context->getHttpPort()) {
                $port = ':' . $this->context->getHttpPort();
            } elseif ('https' === $scheme && 443 != $this->context->getHttpsPort()) {
                $port = ':' . $this->context->getHttpsPort();
            }
            
            $schemeAuthority = self::NETWORK_PATH === $referenceType ? '//' : "$scheme://";
            $schemeAuthority .= $host.$port;
        }
        
        if (self::RELATIVE_PATH === $referenceType) {
            $url = self::getRelativePath($this->context->getPathInfo(), $url);
        } else {
            $url = $schemeAuthority . $this->context->getBaseUrl() . $url;
        }
        
        return $url;
    }
    
    /**
     * return relative path to $nodeId
     * 
     * @param unknown_type $nodeId
     * @throws RouteNotFoundException
     */
    protected function getNodeAlias($nodeId)
    {
        $alias = '';
        
        if ($nodeId != Node::ROOT_NODE_ID) {
            $node = $this->documentManager->getDocument('Node', array('nodeId' => $nodeId));
            
            if (isset($node)) {
                $alias = $this->getNodeAlias($node->getParentId()) . '/' . $node->getAlias();
            } else {
                throw new RouteNotFoundException(
                    sprintf('Unable to generate a URL for the node "%s" as such node does not exist.', $nodeId)
                );
            }
        }
        
        return $alias;
    }
}
