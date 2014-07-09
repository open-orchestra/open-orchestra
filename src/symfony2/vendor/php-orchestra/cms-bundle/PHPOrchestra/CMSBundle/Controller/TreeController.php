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
        
        foreach ($nodes as &$node) {
            $node['url'] = $this->generateUrl('php_orchestra_cms_nodeform', array('nodeId' => $node['_id']));
            $node['class'] = ($node['deleted'] == true) ? 'deleted' : '';
        }
        $nodes = TreeHelper::createTree($nodes, '_id', 'parentId');

        return $this->getRender($nodes, 'Pages');
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
        }
        
        $templates = TreeHelper::createTree($templates);
        
        return $this->getRender($templates, 'Gabarits');
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
