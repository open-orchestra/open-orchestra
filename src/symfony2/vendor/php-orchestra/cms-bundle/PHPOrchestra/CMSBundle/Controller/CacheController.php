<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Noël Gilain <noel.gilain@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use PHPOrchestra\CMSBundle\Routing\PhpOrchestraUrlMatcher;

class CacheController extends Controller
{
    /**
     * Delete all routing cache 
     */
    public function clearRoutingCacheAction()
    {
        $cacheService = $this->container->get('phporchestra_cms.cachemanager');
        
        $cacheService->deleteKeys(PhpOrchestraUrlMatcher::PATH_PREFIX . '*');
        
        return $this->render('PHPOrchestraCMSBundle:BackOffice/Tools:clearRoutingCache.html.twig');
    }
}
