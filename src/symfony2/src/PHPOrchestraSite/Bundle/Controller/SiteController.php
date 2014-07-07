<?php

namespace PHPOrchestraSite\Bundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\CssSelector\XPath\Extension\NodeExtension;
use PHPOrchestra\CMSBundle\Form\Type\NodeType;
use PHPOrchestra\CMSBundle\Helper\NodesHelper;
use PHPOrchestra\CMSBundle\Form\Type\BlockChoiceType;
use PHPOrchestra\CMSBundle\Controller\NodeController;
use PHPOrchestra\CMSBundle\Model\Area;
use PHPOrchestra\CMSBundle\Exception\NonExistingDocumentException;
use Model\PHPOrchestraCMSBundle\Base\Block;

/**
 * Description of SiteController
 *
 * @author Ayman AWAD <ayman.awad@businessdecision.com>
 */
class SiteController extends NodeController
{
    /**
     * Function to show all blocks 
     *
     * @param string $nodeId id of block
     */
    public function nodePageAction($nodeId)
    {
        
        $node = $this->get('phporchestra_cms.documentmanager')->getDocument('Node', array('nodeId' => $nodeId));
        
        if (is_null($node)) {
            throw new NonExistingDocumentException("Node not found");
        }
        
        $areas = $node->getAreas();
        $this->getExternalBlocks();
        if (is_array($areas)) {
            foreach ($areas as $area) {
                $this->getBlocks(new Area($area), $nodeId);
            }
        }

        $response = $this->render(
            'PHPOrchestraSiteBundle:SitePages:show.html.twig',
            array(
                'node' => $node,
                'blocks' => $this->getBlocksNoparam()
            )
        );
            
        return $response;
    }
}
