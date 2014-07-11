<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Nicolas ANNE <nicolas.anne@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use PHPOrchestra\CMSBundle\Helper\TreeHelper;

class TreeController extends Controller
{
    
    /**
     * List all nodes
     * 
     */
    public function showTreeNodesAction(Request $request)
    {
        $nodes = $this->get('phporchestra_cms.documentmanager')->getNodesInLastVersion();
        
        $listParentId = array();
        
        foreach ($nodes as &$node) {
            $node['url'] = $this->generateUrl('php_orchestra_cms_nodeform', array('nodeId' => $node['_id']));
            $node['class'] = ($node['deleted'] == true) ? 'deleted' : '';
            $node['action'] = array(
                'css' => 'fa fa-trash-o',
                'text' => '',
                'js' => array(
	                'url' => $this->generateUrl('php_orchestra_cms_bo_jscontextmenudispatcher', array('cmd' => 'confirmDeleteNode')),
	                'value' => array('nodeId' => $node['_id'])
	            )
            );
            if(!in_array($node['_id'], $listParentId)){
            	$listParentId[] = $node['_id'];
            }
        }
        
        $count = 0;
        foreach($listParentId as $parentId){
        	$nodeId = $parentId.'-'.$count;
            array_push($nodes, array(
                '_id' => $nodeId,
                'parentId' => $parentId,
                'name' => '',
                'url' => '',
                'class' => '',
                'action' => array(
                    'css' => 'fa fa-file',
                    'text' => 'Nouvelle page',
                    'js' => array(
                        'url' => $this->generateUrl('php_orchestra_cms_bo_jscontextmenudispatcher', array('cmd' => 'createNode')),
                        'value' => array('parentId' => $parentId)
                    )
                )
            ));
            $count++;
        }
        
        $nodes = TreeHelper::createTree($nodes, '_id', 'parentId');

        return $this->getRender($nodes, $this->get('translator')->trans('edito.nodes', array(), 'backOffice'));
    }
    /**
     * List all templates
     * 
     */
    public function showTreeTemplatesAction(Request $request)
    {
    	
    	$templates = $this->get('phporchestra_cms.documentmanager')->getTemplatesInLastVersion();
        
        foreach ($templates as $key => &$template) {
            $template['url'] = $this->generateUrl(
                'php_orchestra_cms_templateform',
                array('templateId' => $template['_id'])
            );
            $template['class'] = ($template['deleted'] == true) ? 'deleted' : '';
            $template['action'] = array(
                'css' => 'fa fa-trash-o',
                'text' => '',
                'js' => array(
                    'url' => $this->generateUrl('php_orchestra_cms_bo_jscontextmenudispatcher', array('cmd' => 'confirmDeleteTemplate')),
                    'value' => array('templateId' => $template['_id'])
                )
            );
        }
        
        $templateId = time();

        array_push($templates, array(
            '_id' => $templateId,
            'name' => '',
            'url' => '',
            'class' => '',
            'action' => array(
                'css' => 'fa fa-file',
                'text' => 'Nouveau gabarit',
                'js' => array(
                    'url' => $this->generateUrl('php_orchestra_cms_bo_jscontextmenudispatcher', array('cmd' => 'createTemplate')),
                    'value' => array()
                )
            )
        ));

        $templates = TreeHelper::createTree($templates);
        
        return $this->getRender($templates, $this->get('translator')->trans('edito.templates', array(), 'backOffice'));
    }
    
    /**
     * Render tree
     * 
     */
    public function getRender($links, $name)
    {
        return $this->render(
            'PHPOrchestraCMSBundle:Tree:tree.html.twig',
            array(
                'name' => $name,
                'links' => $links
            )
        );
    }
}
