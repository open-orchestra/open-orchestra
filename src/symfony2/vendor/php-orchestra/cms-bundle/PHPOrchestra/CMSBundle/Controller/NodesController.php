<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Nicolas ANNE <nicolas.anne@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use PHPOrchestra\CMSBundle\Classes\DocumentLoader;
use Symfony\Component\HttpFoundation\Request;
use PHPOrchestra\CMSBundle\Helper\NodesHelper;

class NodesController extends Controller
{

    /**
     * List all nodes
     * 
     */
    public function showAllNodesAction(Request $request)
    {
        $nodes = DocumentLoader::getDocuments('Node', array(), $this->container->get('mandango'));
        return new JsonResponse(array(
            'success' => true,
            'data' => NodesHelper::formatNodes($nodes)
        ));
    }
}
