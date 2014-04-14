<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Noël Gilain <noel.gilain@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use PHPOrchestra\CMSBundle\Model\Area;

class SamplesController extends Controller
{
    
    /**
     * Render a sampleblock
     * 
     * @param String[] $block array containing custom attributes
     */
    public function sampleShowAction($elementsList, $_page_parameters = array())
    {
        $datetime = time();
        
        $response = $this->render(
            'PHPOrchestraCMSBundle:Samples:blocSample.html.twig',
            array('elementsList' => $elementsList, 'parameters' => $_page_parameters, 'datetime' => $datetime)
        );
        
        $response->setPublic();
        $response->setSharedMaxAge(60);
        $response->headers->addCacheControlDirective('must-revalidate', true);
                
        return $response;
    }

    public function sampleFormAction($prefix)
    {
        return $this->render('PHPOrchestraCMSBundle:Samples:dialogBlocSample.html.twig', array('prefix' => $prefix));
    }
    
}
