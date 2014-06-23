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
use PHPOrchestra\CMSBundle\Helper\NodesHelper;

class NodesController extends Controller
{
    
    /**
     * List all nodes
     * 
     */
    public function showTreeNodesAction(Request $request)
    {
        $nodes = $this->get('phporchestra_cms.documentmanager')->getNodesInLastVersion();
        return $this->render(
            'PHPOrchestraCMSBundle:Tree:tree.html.twig',
            array(
                'name' => 'Pages',
                'path' => 'php_orchestra_cms_nodeform',
                'links' => NodesHelper::createTree($nodes),
                'mode' => 'nodes'
            )
        );
    }
}
