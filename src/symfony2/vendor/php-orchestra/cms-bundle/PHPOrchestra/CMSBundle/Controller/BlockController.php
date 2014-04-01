<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Noël Gilain <noel.gilain@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BlockController extends Controller
{
    /**
     * Render a block
     * 
     * @param String[] $block array containing custom attributes
     */
    public function showAction($block)
    {
        $datetime = time();
        
        $response = $this->render('PHPOrchestraCMSBundle:Block:show.html.twig', array('block' => $block, 'datetime' => $datetime));
        
        $response->setPublic();
        $response->setSharedMaxAge(60);
        $response->headers->addCacheControlDirective('must-revalidate', true);
                
        return $response;
    }
}
