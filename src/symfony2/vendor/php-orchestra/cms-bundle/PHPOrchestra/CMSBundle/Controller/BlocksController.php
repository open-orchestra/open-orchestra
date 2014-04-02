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

class BlocksController extends Controller
{

    /**
     * List all blocks contained in config.yml
     * 
     */
    public function showAllBlocksAction($prefix)
    {
        return $this->render('PHPOrchestraCMSBundle:Blocks:showAllBlocks.html.twig', array('blocks' => $this->container->getParameter('php_orchestra.blocks'), 'prefix' => $prefix));
    }
	
    /**
     * List all nodes
     * 
     */
    public function showAllNodesAction(Request $request)
    {
        $nodes = DocumentLoader::getDocuments('Node', array(), $this->container->get('mandango'));
        foreach($nodes as $key => $node){
        	$nodes[$key] = array("nodeId" => $node->getNodeId(), "name" => $node->getName());
        }
        return new JsonResponse(array(
            'success' => true,
            'data' => $nodes
        ));
    }
    /**
     * List blocks from node filtered by those contained in config.yml
     * 
     */
    public function showBlocksFromNodeAction(Request $request)
    {
    	
        $configBlocks = $this->container->getParameter('php_orchestra.blocks');
        foreach($configBlocks as $key => $configBlock){
        	$configBlocks[$key] = $configBlock['action'];
        }
        $configBlocks = array_flip($configBlocks);
        
        $node = DocumentLoader::getDocument('Node', array('nodeId' => $request->get('nodeId')), $this->container->get('mandango'));
        $blocks = $node->getBlocks();
        $blocksComponent = array();
        $intRank = 0;
        foreach($blocks as $block){
        	$component = $block->getComponent();
        	if(array_key_exists($component, $configBlocks)){
        	   $blocksComponent[] = array('blockId' => $intRank, 'name' => $configBlocks[$component]);
        	}
        	$intRank++;
        }
        
        return new JsonResponse(array(
            'success' => true,
            'data' => $blocksComponent
        ));
    }
}
