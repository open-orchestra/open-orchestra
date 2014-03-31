<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Noël Gilain <noel.gilain@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use PHPOrchestra\CMSBundle\Classes\DocumentLoader;
use PHPOrchestra\CMSBundle\Model\Area;
use PHPOrchestra\CMSBundle\Exception\NonExistingDocumentException;
use Symfony\Component\HttpFoundation\Request;
use PHPOrchestra\CMSBundle\Form\Type\NodeType;

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
     * Render Node
     * 
     * @param int $nodeId
     * @return Response
     */
    public function showAction($nodeId)
    { 
        $node = DocumentLoader::getDocument('Node', array('nodeId' => $nodeId), $this->container->get('mandango'));
        if (is_null($node))
            throw new NonExistingDocumentException("Node not found");
        $areas = $node->getAreas();
        $this->externalBlocks = array();
        
        if (is_array($areas))
            foreach ($areas as $area)
                $this->getBlocks(new Area($area), $nodeId);
        
        return $this->render('PHPOrchestraCMSBundle:Node:show.html.twig', array('node' => $node, 'blocks' => $this->blocks));
    }
    
    
    /** 
     * Get blocks referenced in an area and its subareas
     * 
     * @param Area $area
     * @param string $currentNodeId
     */
    protected function getBlocks(Area $area, $currentNodeId)
    {
        foreach ($area->getBlockReferences() as $blockReference)
            $this->getBlockWithReference($blockReference, $currentNodeId);
        
        foreach ($area->getSubAreas() as $subArea)
            $this->getBlocks($subArea, $currentNodeId);
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
        if ($realNodeId == 0)
            $realNodeId = $currentNodeId;
            
        if (!(isset($this->externalBlocks[$realNodeId])))
            $this->getBlocksFromNode($realNodeId);
        
        if (isset($this->externalBlocks[$realNodeId][$blockReference['blockId']])) {
            $this->blocks[$blockReference['nodeId']][$blockReference['blockId']] = $this->externalBlocks[$realNodeId][$blockReference['blockId']];
            $this->blocks[$blockReference['nodeId']][$blockReference['blockId']]['attributes']['query'] = $this->container->get('request')->query;
        }
    }
    
    
    /**
     * Get blocks from specific Node, and cache them temporary for further request
     * 
     * @param int $nodeId
     */
    protected function getBlocksFromNode($nodeId)
    {
        $this->externalBlocks[$nodeId] = array();
        $node = DocumentLoader::getDocument('Node', array('nodeId' => $nodeId), $this->container->get('mandango'));
        
        if ($node) {
            $blocks = $node->getBlocks();
            if (!is_null($blocks))
                foreach ($blocks as $key => $block) {
                    $this->externalBlocks[$nodeId][$key]['component'] = $block->getComponent();
                    $this->externalBlocks[$nodeId][$key]['attributes'] = $block->getAttributes();
                }
        }
    }
    
    
     /**
     * Test purpose : render a basic Node form
     * 
     * @param Request $request
     * @return Response
     */
    public function formAction($nodeId, Request $request)
    {
        $mandango = $this->container->get('mandango'); 
        
        if ($nodeId == 0)
            $node = $mandango->create('Model\PHPOrchestraCMSBundle\Node');
        
        else {
            $node = DocumentLoader::getDocument('Node', array('nodeId' => $nodeId), $this->container->get('mandango'));
            $node->setVersion($node->getVersion() + 1);
        }
            
        $form = $this->createForm(new NodeType(), $node);
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $node->setId(null);
            $node->setIsNew(true);
            
            $node->save();
            
            return $this->redirect($this->generateUrl('php_orchestra_cms_node', array('nodeId' => $node->getNodeId())));
        }
            
        return $this->render('PHPOrchestraCMSBundle:Node:form.html.twig', array(
            'form' => $form->createView(),
        ));    
    }

    /**
     * Test purpose : inject a sample Node in MongoDB
     * 
     * @return Response
     */
    public function addSampleAction()
    {
        $mandango = $this->container->get('mandango');

        $nodesRepo = $mandango->getRepository('Model\PHPOrchestraCMSBundle\Node');
//        $nodesRepo->remove();

// Block #1 : Site Menu
        $block1 = $mandango->create('Model\PHPOrchestraCMSBundle\Block')
//            ->setComponent('PHPOrchestraCMSBundle:Block:show')
            ->setComponent('PHPOrchestraCMSBundle:BlockExample:show0')  
            ->setAttributes(array('rubrique A' => 'Qui sommes-nous ?', 'rubrique B' => 'pourquoi nous choisir ?', 'rubrique C' => 'Nos agences'));
        
// Block #2 : Left Menu
        $block2 = $mandango->create('Model\PHPOrchestraCMSBundle\Block')
            ->setComponent('PHPOrchestraCMSBundle:BlockExample:show1')  
            ->setAttributes(array('lien 1' => 'http://www.google.fr', 'lien 2' => 'http://www.yahoo.fr', 'lien 3' => 'http://altavista.box.co.uk'));
        
// Block #3 : News #1
        $block3 = $mandango->create('Model\PHPOrchestraCMSBundle\Block')
            ->setComponent('PHPOrchestraCMSBundle:BlockExample:show1')  
            ->setAttributes(array('title' => 'News 1', 'content' => 'Donec bibendum at nibh eget imperdiet. Mauris eget justo augue. Fusce fermentum iaculis erat, sollicitudin elementum enim sodales eu. Donec a ante tortor. Suspendisse a.'));
        
// Block #4 : News #2
        $block4 = $mandango->create('Model\PHPOrchestraCMSBundle\Block')
            ->setComponent('PHPOrchestraCMSBundle:BlockExample:show1')  
            ->setAttributes(array('title' => 'News #2', 'content' => 'Aliquam convallis facilisis nulla, id ultricies ipsum cursus eu. Proin augue quam, iaculis id nisi ac, rutrum blandit leo. In leo ante, scelerisque tempus lacinia in, sollicitudin quis justo. Vestibulum.'));
        
// Block #5 : News #3
        $block5 = $mandango->create('Model\PHPOrchestraCMSBundle\Block')
            ->setComponent('PHPOrchestraCMSBundle:BlockExample:show0')  
            ->setAttributes(array('content' => 'News #3', 'content' => 'Phasellus condimentum diam placerat varius iaculis. Aenean dictum, libero in sollicitudin hendrerit, nulla mi elementum massa, eget mattis lorem enim vel magna. Fusce suscipit orci vitae vestibulum.'));
        
// Block #6 : Pub
        $block6 = $mandango->create('Model\PHPOrchestraCMSBundle\Block')
            ->setComponent('PHPOrchestraCMSBundle:BlockExample:show0')  
            ->setAttributes(array('image' => 'mapub.jpg'));

// Block #7 : Legal mentions
        $block7 = $mandango->create('Model\PHPOrchestraCMSBundle\Block')
            ->setComponent('PHPOrchestraCMSBundle:BlockExample:show0')  
            ->setAttributes(array('Lien A' => 'Mentions légales', 'Lien B' => 'Nous contacter'));
            
// Area 1 : Header
        $area1 = new area();
        $area1->setId('header')
            ->addBlockReferences(0, 0);
        
// Area 2-1 : Left menu
        $area21 = new area();
        $area21
            ->setId('left_menu')
            ->addBlockReferences(200, 1);
        
// Area 2-2 : Content
        $area22 = new area();
        $area22
            ->setId('content')
            ->addBlockReferences(10, 2)
            ->addBlockReferences(0, 3)
            ->addBlockReferences(0, 5);

// Area 2-3 : Skycrapper
        $area23 = new area();
        $area23
            ->setId('skycrapper')
            ->addBlockReferences(10, 5);
            
// Area 2 : Main
        $area2 = new area();
        $area2
            ->setId('main')
            ->addSubArea($area21)
            ->addSubArea($area22)
            ->addSubArea($area23);
            
// Area 3 : Header
        $area3 = new area();
        $area3->setId('footer')
            ->addBlockReferences(10, 6);
            
// Node
        $node = $mandango->create('Model\PHPOrchestraCMSBundle\Node')
            ->setNodeId('sample')
            ->setSiteId(1)
            ->setName('Home site avec ref Repo 0 v10')
            ->setVersion(2)
            ->setLanguage('fr')
            ->addBlocks(array($block1, $block2, $block3, $block4, $block5, $block6, $block7))
            ->setAreas(array($area1->toArray(), $area2->toArray(), $area3->toArray()));
            
        $node->save();
        
        $nodes = $mandango->getRepository('Model\PHPOrchestraCMSBundle\Node')->createQuery();
        
        return $this->render('PHPOrchestraCMSBundle:Default:index.html.twig', array('nodes' => $nodes));
    }
    
}
