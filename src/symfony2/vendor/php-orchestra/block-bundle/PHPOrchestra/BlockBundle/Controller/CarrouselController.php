<?php

namespace PHPOrchestra\BlockBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of CarousselController
 * this controller allow to generate a caroussel
 * @author Ayman AWAD <ayman.awad@businessdecision.com>
 */

class CarrouselController extends Controller
{
    function showAction($pictures = array(), $width , $height)
    {
    	return $this->render('PHPOrchestraBlockBundle:Carrousel:show.html.twig', array(
    			'pictures' => $pictures,
    	        'width'=> $width,
    			'height'=> $height	
    	));
    }	
    
    /**
     * Render the dialog form
     *
     * @param string $prefix
     */
    public function formAction($prefix)
    {
    	$form = $this->get('form.factory')
    	->createNamedBuilder($prefix, 'form', null)
    	->add(
    			'pictures',
    			'width',
    			'height'
    	)
    	->getForm();
    
    	return $this->render(
    			'PHPOrchestraBlockBundle:Carrousel:form.html.twig',
    			array('form' => $form->createView())
    	);
    }
}
