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
    public function getGenerateInformations($request)
    {
        $component = '';
        $attributs = array();
        $attributs = $request->request->all();
        $allowed=array_filter(
            array_keys($attributs),
            function ($key) {
                return preg_match('/^attributs_/', $key);
            }
        );
        $attributs = array_intersect_key($attributs, array_flip($allowed));
        $attributs = array_combine(
            array_map(
                function ($value) {
                    return preg_replace('/^attributs_/', '', $value);
                },
                array_keys($attributs)
            ),
            array_values($attributs)
        );
        $component = $request->request->get('component');
        return array($component, $attributs);
    }
    /**
     * 
     * Get the component and attributs informations in block load case 
     * @param Request $request
     * 
     */
    public function getLoadInformations($request)
    {
        $component = '';
        $attributs = array();
        $block = $this->get('phporchestra_cms.documentmanager')->getBlockInNode(
            $request->request->get('nodeId'),
            $request->request->get('blockId')
        );
        if ($block) {
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
    public function getPreview($request)
    {
        $component = '';
        $attributs = array();
        if ($request->request->get('component') !== null) {
            list($component, $attributs) = $this->getGenerateInformations($request);
        } elseif ($request->request->get('nodeId') !== null && $request->request->get('blockId') !== null) {
        	list($component, $attributs) = $this->getLoadInformations($request);
        }
        if ($component !== '') {
            $response  = $this->forward('PHPOrchestraCMSBundle:Block/'.$component.':showBack', $attributs);
            return new JsonResponse(
                array(
                    'success' => true,
                    'data' => $response->getContent()
                )
            );
        } else {
            return new JsonResponse(
                array(
                    'success' => true,
                    'data' => 'No Preview'
                )
            );
        }
    }
    
    public function getRecRefresh($request, $form, $refresh){
    	$children = $form->all();
    	$restart = false;
    	if(count($children) > 0){
	        foreach($children as $child){
	            $view = $child->createView();
                if($request->request->get($view->vars['id'])){
    	            if(!array_key_exists($view->vars['name'], $refresh)){
	                    $refresh[$view->vars['name']] = $request->request->get($view->vars['id']);
	                    $restart = true;
	                }
                }
                else{
                    if(!array_key_exists($view->vars['name'], $refresh)){
                    	$refresh[$view->vars['name']] = array();
                    }
                	list($restart, $refresh[$view->vars['name']]) = $this->getRecRefresh($request, $child, $refresh[$view->vars['name']]);
                }
	            if($restart){
	            	break;
	            }
	        }
    	}
        return array($restart, $refresh);
    }
    /**
     * 
     * Render the node Block form after refresh request
     * @param Request $request
     * @param $type
     * 
     */
    public function getRefresh($request, $type)
    {
        $refresh = array('is_node' => ($type == 'node'));
        if(is_array($request->request->get('blocks'))){
            $refresh = array_merge($refresh, $request->request->get('blocks'));
        }
        else{
            $form = $this->createForm('blocks', $refresh);
            list($restart, $refresh) = $this->getRecRefresh($request, $form, $refresh);
            while($restart){
                $form = $this->createForm('blocks', $refresh);
            	list($restart, $refresh) = $this->getRecRefresh($request, $form, $refresh);
        	}
        }
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
        
        if ($request->request->get('preview') !== null) {
            return $this->getPreview($request);
        } elseif ($request->request->get('refresh') !== null) {
            return $this->getRefresh($request, $type);
        } else {
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
