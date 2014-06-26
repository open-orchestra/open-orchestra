<?php

namespace PHPOrchestra\BlockBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


/**
 * Description of HeaderController
 *
 * @author Ayman AWAD <ayman.awad@businessdecision.com>
 */
class HeaderController extends Controller
{
     /**
	 * Function to show header block
	 *
	 * @param string $id id of block
	 * @param string $class class of block
	 * @param array $block array of blocks 
	 */
    function headerShowAction($id, $class, $block = array())
    {
    	$response = $this->render(
    			'PHPOrchestraBlockBundle:Header:show.html.twig',
    			array(
    					'id' => $id,
    					'class' => $class,
    					'block' => $block
    			)
    	);
    	return $response;
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
    			'id',
    			'class',
    			'block'
    	)
    	->getForm();
    
    	return $this->render(
    			'PHPOrchestraBlockBundle:Header:form.html.twig',
    			array('form' => $form->createView())
    	);
    }
}
