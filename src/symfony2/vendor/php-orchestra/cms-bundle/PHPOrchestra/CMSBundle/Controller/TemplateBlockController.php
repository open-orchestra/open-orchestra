<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Nicolas Anne <nicolas.anne@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use PHPOrchestra\CMSBundle\Form\Type\BlockType;
use Symfony\Component\HttpFoundation\Response;

class TemplateBlockController extends Controller
{
    
    /**
     * 
     * Render the template Block form
     * @param Request $request
     * 
     */
    public function formAction()
    {
        $form = $this->createForm(
            new BlockType(),
            null,
            array(
                'inDialog' => true,
                'subForm' => true,
                'js' => 'pagegenerator/template_block.js'
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
