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
use Symfony\Component\HttpFoundation\JsonResponse;

class BlockController extends Controller
{
    
    /**
     * 
     * Render the node Block form
     * @param Request $request
     * 
     */
    public function formAction($type)
    {
    	$request = $this->get('request');
    	$blockType = new BlockType($this->get('phporchestra_cms.documentmanager'), $this->container->getParameter('php_orchestra.blocks'));
    	$action = $this->generateUrl('php_orchestra_cms_blockform', array('type' => $type));
        $inDialog = true;
        $subForm = true;
        $js = 'pagegenerator/'.$type.'_block.js';
        $data = array('is_node' => ($type == 'node'));
    	
        if ($request->getMethod() == 'POST') {
	        $inDialog = false;
	        $subForm = false;
	        $js = '';
	        $formData = $request->request->all();
	        $data = array_merge($data, $formData[$blockType->getName()]);
        }

        $form = $this->createForm(
            $blockType,
            null,
            array(
                'action' => $action,
                'inDialog' => $inDialog,
                'subForm' => $subForm,
                'js' => $js,
                'data' => $data
            )
        );
        
        if ($request->getMethod() == 'POST') {
        	$form->handleRequest($request);
        }
        $render = $this->render(
            'PHPOrchestraCMSBundle:Form:form.html.twig',
            array(
                'form' => $form->createView()
            )
        );

        if ($request->getMethod() == 'POST') {
            return new JsonResponse(
                array(
                    'success' => true,
                    'data' => $render->getContent()
                )
            );
        }
        else{
        	return $render;
        }
    }
}
