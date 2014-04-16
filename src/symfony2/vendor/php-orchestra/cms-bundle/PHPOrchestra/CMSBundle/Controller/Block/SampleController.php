<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Noël Gilain <noel.gilain@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Controller\Block;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use PHPOrchestra\CMSBundle\Model\Area;

class SampleController extends Controller
{
    
    /**
     * Render the sampleblock
     * 
     * @param array $elementsList array containing custom attributes
     * @param array $_page_parameters additional parameters extracted from url
     */
    public function showAction($_title, $_author, $_news, $_page_parameters = array())
    {
        $datetime = time();
        
        $response = $this->render(
            'PHPOrchestraCMSBundle:Block/Sample:show.html.twig',
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
    public function formAction($prefix)
    {
        $form = $this->get('form.factory')->createNamedBuilder($prefix, 'form', null)
            ->add('title', 'text')
            ->add('author', 'text')
            ->add('news', 'text')
            ->getForm();
        
        return $this->render(
            'PHPOrchestraCMSBundle:Block/Sample:form.html.twig',
            array('form' => $form->createView())
        );
    }
}
