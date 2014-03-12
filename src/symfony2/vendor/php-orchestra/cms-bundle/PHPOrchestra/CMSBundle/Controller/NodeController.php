<?php

namespace PHPOrchestra\CMSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use PHPOrchestra\CMSBundle\Classes\Area;

class NodeController extends Controller
{
    public function showAction($nodeId)
    { 
        $node = $this->getNode($nodeId);
        $areas = $node->getAreas();
        $cacheRelatedNodes = array();
        
        if (count($areas) > 0)
            foreach ($areas as $area)
                $cacheRelatedNodes = $this->getRelatedNodes(new Area($area), $cacheRelatedNodes);
        
        return $this->render('PHPOrchestraCMSBundle:Node:show.html.twig', array('node' => $node, 'relatedNodes' => $cacheRelatedNodes));
    }
    
    private function getNode($nodeId)
    {
        $mandango = $this->container->get('mandango');
        $repository = $mandango->getRepository('Model\PHPOrchestraCMSBundle\Node');
        $query = $repository->createQuery();
        $query->criteria(array('nodeId' => (int)$nodeId));
        return $query->one();
    }
    
    private function getRelatedNodes($area, $cache)
    {
    	foreach ($area->getBlockReferences() as $blockReference)
    		if ($blockReference['nodeId'] != 0 && !(isset($cache[$blockReference['nodeId']])))
    		    $cache[$blockReference['nodeId']] = $this->getNode($blockReference['nodeId'])->getBlocks();

        foreach ($area->getSubAreas() as $subArea)
            $cache = $this->getRelatedNodes($subArea, $cache);
            
    	return $cache;
    }
    
}
