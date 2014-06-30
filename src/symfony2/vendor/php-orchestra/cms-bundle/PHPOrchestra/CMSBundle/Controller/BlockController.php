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
     * Get the component and attributs informations in block generate case 
     * @param Request $request
     * 
     */
	public function getGenerateInformations($request){
        $component = '';
        $attributs = array();
		$attributs = $request->query->all();
        $allowed=array_filter(
            array_keys($attributs),
            function($key){
                return preg_match('/^attributs_/', $key);
            });
        $attributs = array_intersect_key($attributs,array_flip($allowed));
        $attributs = array_combine(array_map(function($value) { return preg_replace('/^attributs_/', '', $value); }, array_keys($attributs)), array_values($attributs));
        $component = $request->query->get('component');
        return array($component, $attributs);
	}
    /**
     * 
     * Get the component and attributs informations in block load case 
     * @param Request $request
     * 
     */
	public function getLoadInformations($request){
        $component = '';
        $attributs = array();
    	$block = $this->get('phporchestra_cms.documentmanager')->getBlockInNode($request->query->get('nodeId'), $request->query->get('blockId'));
        if($block){
            $component = $block['component'];
            $attributs = $block['attributes'];
        }
        return array($component, $attributs);
    }
	
    /**
     * 
     * Render the preview of a Block
     * @param Request $request
     * 
     */
    public function getPreview($request){
        $component = '';
        $attributs = array();
        if($request->query->get('component') !== null){
            list($component, $attributs) = $this->getGenerateInformations($request);
        }
        elseif($request->query->get('nodeId') !== null && $request->query->get('blockId') !== null){
            list($component, $attributs) = $this->getLoadInformations($request);
        }
        if($component !== ''){
            $response  = $this->forward('PHPOrchestraCMSBundle:Block/'.$component.':showBack', $attributs);
            return new JsonResponse(
                array(
                    'success' => true,
                    'data' => $response->getContent()
                )
            );
        }
        else{
            return new JsonResponse(
                array(
                    'success' => true,
                    'data' => 'No Preview'
                )
            );
        }
    }
	
    /**
     * 
     * Render the node Block form after refresh request
     * @param Request $request
     * @param $type
     * 
     */
    public function getRefresh($request, $type){
    	$refresh = array('is_node' => ($type == 'node'));
        $refresh = array_merge($refresh, $request->query->get('blocks'));
        $form = $this->createForm(
            'blocks',
            $refresh,
            array(
                'action' => $this->generateUrl('php_orchestra_cms_blockform', array('type' => $type)),
                'inDialog' => false,
                'subForm' => false,
                'beginJs' => array('pagegenerator/dialogNode.js'),
            )
        );
        $render = $this->render(
            'PHPOrchestraCMSBundle:Form:form.html.twig',
            array(
                'form' => $form->createView()
            )
        );
        return new JsonResponse(
            array(
                'success' => true,
                'data' => $render->getContent()
            )
        );
    }
	/**
     * 
     * Render the node Block form
     * @param $type
     * 
     */
    public function formAction($type)
    {
    	$request = $this->get('request');
    	
        if ($request->getMethod() == 'GET' && $request->query->get('preview') !== null) {
        	return $this->getPreview($request);
        }
    	elseif ($request->getMethod() == 'GET' && $request->query->get('refresh') !== null){
    		return $this->getRefresh($request, $type);
    	}
    	else{
	        $refresh = array('is_node' => ($type == 'node'));
	        $form = $this->createForm(
	            'blocks',
	            $refresh,
	            array(
	                'action' => $this->generateUrl('php_orchestra_cms_blockform', array('type' => $type)),
	                'inDialog' => true,
	                'subForm' => true,
	                'beginJs' => array('pagegenerator/'.$type.'_block.js?'.time(), 'pagegenerator/dialogNode.js'),
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
}
