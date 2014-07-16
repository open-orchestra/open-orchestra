<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Noël Gilain <noel.gilain@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use PHPOrchestra\CMSBundle\Model\Area;
use PHPOrchestra\CMSBundle\Model\Node;
use PHPOrchestra\CMSBundle\Exception\NonExistingDocumentException;
use Symfony\Component\HttpFoundation\Request;
use PHPOrchestra\CMSBundle\Form\Type\NodeType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use PHPOrchestra\CMSBundle\Helper\NodeHelper;

class NodeController extends Controller
{
    
    /**
     * Cache containing blocks potentially used in current node.
     * This cache contains all blocks defined in nodes that are mentionned
     * in block references of the current node.
     * This is to prevent multiple loading of the same node document
     * when same external node is linked several times in the current node
     * 
     * @var Array
     */
    private $externalBlocks = array();
    
    
    /**
     * Contains blocks used in the current node,
     * either defined in current or external node
     * 
     * @var Array
     */
    private $blocks = array();
    
    
    
    /**
     * A getter for the variable externalBlocks
     *
     * @param none
     */
    public function getExternalBlocks()
    {
        return $this->externalBlocks;
    }
    
    /**
     * A getter for the variable externalBlocks
     *
     * @param none
     */
    public function getBlocksNoparam()
    {
        return $this->blocks;
    }
    
    /**
     * Render Node
     * 
     * @param int $nodeId
     * @return Response
     */
    public function showAction($nodeId)
    {
        $node = $this->get('phporchestra_cms.documentmanager')->getDocument('Node', array('nodeId' => $nodeId));
        if (is_null($node)) {
            throw new NonExistingDocumentException("Node not found");
        }
        $areas = $node->getAreas();
        $this->externalBlocks = array();
        
        if (is_array($areas)) {
            foreach ($areas as $area) {
                $this->getBlocks(new Area($area), $nodeId);
            }
        }
        
        $response = $this->render(
            'PHPOrchestraCMSBundle:Node:show.html.twig',
            array(
                'node' => $node,
                'blocks' => $this->blocks,
                'datetime' => time()
            )
        );
        
        $response->setPublic();
        $response->setSharedMaxAge(100);
        $response->headers->addCacheControlDirective('must-revalidate', true);
        
        return $response;
    }
    
    
    /** 
     * Get blocks referenced in an area and its subareas
     * 
     * @param Area $area
     * @param string $currentNodeId
     */
    protected function getBlocks(Area $area, $currentNodeId)
    {
        foreach ($area->getBlockReferences() as $blockReference) {
            $this->getBlockWithReference($blockReference, $currentNodeId);
        }
        
        foreach ($area->getSubAreas() as $subArea) {
            $this->getBlocks($subArea, $currentNodeId);
        }
    }
    
    
    /**
     * Get block with matching nodeId/blockId
     * and set it in the controller
     * 
     * @param Array $blockReference
     * @param string $currentNodeId
     */
    protected function getBlockWithReference($blockReference, $currentNodeId)
    {
        $realNodeId = $blockReference['nodeId'];
        if ($realNodeId == 0) {
            $realNodeId = $currentNodeId;
        }
        
        if (!(isset($this->externalBlocks[$realNodeId]))) {
            $this->getBlocksFromNode($realNodeId);
        }
        
        if (isset($this->externalBlocks[$realNodeId][$blockReference['blockId']])) {
            $this->blocks[$blockReference['nodeId']][$blockReference['blockId']] =
                $this->externalBlocks[$realNodeId][$blockReference['blockId']];
            $this->blocks[$blockReference['nodeId']][$blockReference['blockId']]
                ['attributes']['_page_parameters']['url'] =
                    $this->container->get('request')->attributes->get('module_parameters');
        }
        
        $this->blocks[$blockReference['nodeId']][$blockReference['blockId']]['attributes']
            ['_page_parameters']['query'] = $this->getRequest()->query->all();
        $this->blocks[$blockReference['nodeId']][$blockReference['blockId']]['attributes']
            ['_page_parameters']['post'] = $this->getRequest()->request->all();
    }
    
    
    /**
     * Get blocks from specific Node, and cache them temporary for further request
     * 
     * @param int $nodeId
     */
    protected function getBlocksFromNode($nodeId)
    {
        $this->externalBlocks[$nodeId] = array();
        $node = $this->get('phporchestra_cms.documentmanager')->getDocument('Node', array('nodeId' => $nodeId));
        
        if ($node) {
            $blocks = $node->getBlocks();
            if (!is_null($blocks)) {
                foreach ($blocks as $key => $block) {
                    $this->externalBlocks[$nodeId][$key]['component'] = $block->getComponent();
                    $this->externalBlocks[$nodeId][$key]['attributes'] = $block->getAttributes();
                }
            }
        }
    }
    
    
     /**
     * Test purpose : render a basic Node form
     * 
     * @param int nodeId
     * @param string parentId
     * @return Response
     */
    public function formAction($nodeId = 0)
    {
        $request = $this->get('request');
        $documentManager = $this->container->get('phporchestra_cms.documentmanager');
        
        if (empty($nodeId)) {
            $node = $documentManager->createDocument('Node');
            $node->setSiteId(1);
            $node->setLanguage('fr');
        } else {
            $node = $documentManager->getDocument(
                'Node',
                array('nodeId' => $nodeId)
            );
            $node->setVersion($node->getVersion() + 1);
        }
        $doSave = ($request->getMethod() == 'POST');
        if ($request->request->get('ajax')) {
            $node->fromArray($request->request->all());
            $doSave = true;
        } else {
            $form = $this->createForm(
                'node',
                $node,
                array(
                    'inDialog' => true,
                    'beginJs' => array('pagegenerator/dialogNode.js', 'pagegenerator/model.js'),
                    'endJs' => array('pagegenerator/node.js?'.time()),
                    'action' => $this->getRequest()->getUri()
                )
            );
            if ($doSave) {
                $form->handleRequest($request);
                $doSave = $form->isValid();
            }
        }
        if ($doSave) {
            if (!$node->getDeleted()) {
                $node->setId(null);
                $node->setIsNew(true);
                $node->save();

                /*$soft = $this->get('phporchestra_cms.indexHelper');
                $soft->index($node, 'Node');*/
            } else {
                $this->deleteTree($node->getNodeId());
            }
            
            $response = $this->render(
                'PHPOrchestraCMSBundle:BackOffice/Dialogs:confirmation.html.twig',
                array(
                    'dialogId' => '',
                    'dialogTitle' => 'Modification du node',
                    'dialogMessage' => 'Modification ok',
                )
            );
            return new JsonResponse(
                array(
                    'dialog' => $response->getContent(),
                )
            );
        }
                
        return $this->render(
            'PHPOrchestraCMSBundle:BackOffice/Editorial:template.html.twig',
            array(
                'mainTitle' => 'Gestion des pages',
                'tableTitle' => '',
                'form' => $form->createView()
            )
        );
    }

    /**
     * Recursivly delete a tree
     * 
     * @param string $nodeId
     */
    protected function deleteTree($nodeId)
    {
        /*$soft = $this->get('phporchestra_cms.indexHelper');
        $soft->deleteIndex($nodeId);*/
        
        $documentManager = $this->get('phporchestra_cms.documentmanager');
        
        $nodeVersions = $documentManager->getDocuments('Node', array('nodeId' => $nodeId));
        
        foreach ($nodeVersions as $node) {
            $node->markAsDeleted();
        };
        
        $sons = $documentManager->getNodeSons($nodeId);
        
        foreach ($sons as $son) {
            $this->deleteTree($son['_id']);
        }
        return true;
    }
}
