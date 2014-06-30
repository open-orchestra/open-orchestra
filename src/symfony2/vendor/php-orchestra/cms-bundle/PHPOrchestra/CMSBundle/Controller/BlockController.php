<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Nicolas Anne <nicolas.anne@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
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
    	$action = $this->generateUrl('php_orchestra_cms_blockform', array('type' => $type));
        $inDialog = true;
        $subForm = true;
        $js = 'pagegenerator/'.$type.'_block.js?'.time();
        $refresh = array('is_node' => ($type == 'node'));
        if ($request->getMethod() == 'GET' && $request->query->get('refresh') !== null) {
	        $inDialog = false;
	        $subForm = false;
	        $js = '';
            $refresh = array_merge($refresh, $request->query->get('blocks'));
        }
        $form = $this->createForm(
            'blocks',
            $refresh,
            array(
                'action' => $action,
                'inDialog' => $inDialog,
                'subForm' => $subForm,
                'beginJs' => array($js, 'pagegenerator/dialogNode.js'),
            )
        );
        
        $render = $this->render(
            'PHPOrchestraCMSBundle:Form:form.html.twig',
            array(
                'form' => $form->createView()
            )
        );
        if ($request->getMethod() == 'GET' && $request->query->get('refresh') !== null) {
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
