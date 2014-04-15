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
     * Render the sampleblock
     * 
     * @param array $elementsList array containing custom attributes
     * @param array $_page_parameters additional parameters extracted from url
     */
    public function sampleShowAction($_title, $_author, $_news, $_page_parameters = array())
    {
        $datetime = time();
        
        $response = $this->render(
            'PHPOrchestraCMSBundle:Samples:blocSample.html.twig',
            array(
                  'title' => $_title,
                  'author' => $_author,
                  'news' => $_news,
                  'parameters' => $_page_parameters,
                  'datetime' => $datetime
            )
        );
        
        $response->setPublic();
        $response->setSharedMaxAge(60);
        $response->headers->addCacheControlDirective('must-revalidate', true);
        
        return $response;
    }

    /**
     * Render the dialog form
     * 
     * @param string $prefix
     */
    public function sampleFormAction($prefix)
    {
        $form = $this->get('form.factory')->createNamedBuilder($prefix, 'form', null)
            ->add('title', 'text')
            ->add('author', 'text')
            ->add('news', 'text')
            ->getForm();
        
        return $this->render(
                            'PHPOrchestraCMSBundle:Samples:dialogBlocSample.html.twig',
                            array('form' => $form->createView())
        );
    }
    
}
