<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Noël Gilain <noel.gilain@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use PHPOrchestra\CMSBundle\Classes\DocumentLoader;
use PHPOrchestra\CMSBundle\Classes\Area;

class NodeController extends Controller
{
	
	/**
	 * Cache containing blocks defined in external Nodes
	 * 
	 * @var Mandango\Group\EmbeddedGroup[]
	 */
	private $externalBlocks = array();
	

    /**
     * Render Node
     * 
     * @param int $nodeId
     * @return Response
     */
    public function showAction($nodeId)
    { 
        $node = DocumentLoader::getDocument('Node', array('nodeId' => (int)$nodeId), $this->container->get('mandango'));
    	$areas = $node->getAreas();
        $this->externalBlocks = array();
        
        if (is_array($areas))
            foreach ($areas as $area)
                $this->getExternalBlocks(new Area($area));

//        print_r($node);exit();
        
        return $this->render('PHPOrchestraCMSBundle:Node:show.html.twig', array('node' => $node, 'relatedNodes' => $this->externalBlocks));
    }
    
    
    /** 
     * Cache blocks from external Nodes referenced in an area
     * 
     * @param Area $area
     */
    private function getExternalBlocks(Area $area)
    {
    	foreach ($area->getBlockReferences() as $blockReference)
    	   if ($blockReference['nodeId'] != 0 && !(isset($this->cacheRelatedNodes[$blockReference['nodeId']])))
    	       $this->getBlocksFromNode($blockReference['nodeId']);
    		
        foreach ($area->getSubAreas() as $subArea)
            $this->getExternalBlocks($subArea);
    }
    
    
    /**
     * Cache blocks from specific Node
     * 
     * @param int $nodeId
     */
    private function getBlocksFromNode($nodeId)
    {
		$node = DocumentLoader::getDocument('Node', array('nodeId' => $nodeId), $this->container->get('mandango'));
		$this->externalBlocks[$nodeId] = $node->getBlocks();
    }
    
}
