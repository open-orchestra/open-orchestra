<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Nicolas Anne <nicolas.anne@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use PHPOrchestra\CMSBundle\Form\Type\AreaType;
use Symfony\Component\HttpFoundation\Response;

class NodeAreaController extends Controller
{
    
    /**
     * 
     * Render the node Area form
     * @param Request $request
     * 
     */
    public function formAction()
    {
        $form = $this->createForm(
            new AreaType(),
            null,
            array(
                'inDialog' => true,
                'subForm' => true,
                'js' => 'pagegenerator/node_area.js'
            )
        );
        
        return $this->render(
            'PHPOrchestraCMSBundle:Form:form.html.twig',
            array(
                'form' => $form->createView()
            )
        );
    }
}
