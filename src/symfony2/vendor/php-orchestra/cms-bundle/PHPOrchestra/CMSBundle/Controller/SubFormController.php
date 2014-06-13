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
use PHPOrchestra\CMSBundle\Form\Type\BlockType;
use Symfony\Component\HttpFoundation\Response;

class SubFormController extends Controller
{
    
    /**
     * 
     * Render the templates form
     * @param Request $request
     * 
     */
    public function areaAction(Request $request)
    {
        $form = $this->createForm(
            new AreaType(),
            null,
            array(
                'inDialog' => true,
                'subForm' => true,
                'js' => 'pagegenerator/area/begin.js'
            )
        );
        
        return $this->render(
            'PHPOrchestraCMSBundle:Form:form.html.twig',
            array(
                'form' => $form->createView()
            )
        );
    }
    public function blockAction(Request $request)
    {
        $form = $this->createForm(
            new BlockType(),
            null,
            array(
                'inDialog' => true,
                'subForm' => true,
                'js' => 'pagegenerator/block/begin.js'
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
