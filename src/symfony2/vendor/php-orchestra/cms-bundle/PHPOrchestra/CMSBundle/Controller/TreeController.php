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
    public function showTreeNodesAction()
    {
        $nodes = $this->get('phporchestra_cms.documentmanager')->getNodesInLastVersion(array(array('$match' => array('deleted' => false))));
        
        $listParentId = array();
        foreach ($nodes as &$node) {
            $node['url'] = $this->generateUrl('php_orchestra_cms_nodeform', array('nodeId' => $node['_id']));
            $node['class'] = ($node['deleted'] == true) ? 'deleted' : '';
            $node['action'] = array(
                'css' => 'fa fa-trash-o',
                'text' => '',
                'url' => $this->generateUrl('php_orchestra_cms_bo_jscontextmenudispatcher', array('cmd' => 'confirmDeleteNode')),
            );
            $node['parameter'] = array('nodeId' => $node['_id'], 'name' => $node['name']);
            if(!in_array($node['_id'], $listParentId)){
            	$listParentId[] = $node['_id'];
            }
        }
        foreach($listParentId as $parentId){
            array_push($nodes, array(
                '_id' => uniqid('node-'),
                'parentId' => $parentId,
                'name' => '',
                'url' => '#',
                'class' => 'ui-state-unsortable',
                'action' => array(
                    'css' => 'fa fa-file',
                    'text' => 'Nouvelle page',
                    'url' => $this->generateUrl('php_orchestra_cms_bo_jscontextmenudispatcher', array('cmd' => 'createNode')),
                ),
                'parameter' => array('parentId' => $parentId)
            ));
        }
        
        $nodes = TreeHelper::createTree($nodes, '_id', 'parentId');

        return $this->getRender($nodes, $this->generateUrl('php_orchestra_cms_bo_jscontextmenudispatcher', array('cmd' => 'moveNode')), $this->get('translator')->trans('edito.nodes', array(), 'backOffice'));
    }
    /**
     * List all templates
     * 
     */
    public function showTreeTemplatesAction()
    {
    	
    	$templates = $this->get('phporchestra_cms.documentmanager')->getTemplatesInLastVersion(array(array('$match' => array('deleted' => false))));
    	
        
        foreach ($templates as $key => &$template) {
            $template['url'] = $this->generateUrl(
                'php_orchestra_cms_templateform',
                array('templateId' => $template['_id'])
            );
            $template['class'] = ($template['deleted'] == true) ? 'deleted' : '';
            $template['action'] = array(
                'css' => 'fa fa-trash-o',
                'text' => '',
                'url' => $this->generateUrl('php_orchestra_cms_bo_jscontextmenudispatcher', array('cmd' => 'confirmDeleteTemplate')),
            );
            $template['parameter'] = array('templateId' => $template['_id'], 'name' => $template['name']);
        }
        
        array_push($templates, array(
            '_id' => uniqid('template-'),
            'name' => '',
            'url' => '#',
            'class' => 'ui-state-unsortable',
            'action' => array(
                'css' => 'fa fa-file',
                'text' => 'Nouveau gabarit',
                'url' => $this->generateUrl('php_orchestra_cms_bo_jscontextmenudispatcher', array('cmd' => 'createTemplate')),
            ),
            'parameter' => array()
        ));

        $templates = TreeHelper::createTree($templates);
        return $this->getRender($templates, '', $this->get('translator')->trans('edito.templates', array(), 'backOffice'));
    }
    
    /**
     * Render tree
     * 
     */
    public function getRender($links, $moveUrl, $name)
    {
        return $this->render(
            'PHPOrchestraCMSBundle:Tree:tree.html.twig',
            array(
                'name' => $name,
                'moveUrl' => $moveUrl,
                'links' => $links
            )
        );
    }
}
