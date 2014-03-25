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
     * Cache containing blocks relative to current node
     * but defined in external Nodes
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
        $node = DocumentLoader::getDocument('Node', array('nodeId' => $nodeId), $this->container->get('mandango'));
        if (is_null($node))
            throw new NonExistingDocumentException("Node not found");
        $areas = $node->getAreas();
        $this->externalBlocks = array();
        
        if (is_array($areas))
            foreach ($areas as $area)
                $this->getExternalBlocks(new Area($area));
        
        return $this->render('PHPOrchestraCMSBundle:Node:show.html.twig', array('node' => $node, 'relatedNodes' => $this->externalBlocks));
    }
    
    
    /** 
     * Cache blocks from external Nodes referenced in an area
     * 
     * @param Area $area
     */
    protected function getExternalBlocks(Area $area)
    {
        foreach ($area->getBlockReferences() as $blockReference)
           if ($blockReference['nodeId'] != 0 && !(isset($this->cacheRelatedNodes[$blockReference['nodeId']])))
               $this->getBlocksFromNode($blockReference['nodeId']);
        
        foreach ($area->getSubAreas() as $subArea)
            $this->getExternalBlocks($subArea);
    }
    
    
    /**
     * Get blocks from specific Node, and cache them temporary for further request
     * 
     * @param int $nodeId
     */
    protected function getBlocksFromNode($nodeId)
    {
        $node = DocumentLoader::getDocument('Node', array('nodeId' => $nodeId), $this->container->get('mandango'));
        if ($node)
            $this->externalBlocks[$nodeId] = $node->getBlocks();
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
        else
            $node = DocumentLoader::getDocument('Node', array('nodeId' => $nodeId), $this->container->get('mandango'));
                
        $form = $this->createForm(new NodeType(), $node);
        $form->handleRequest($request);
        
        if ($form->isValid())
        {
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
        $nodesRepo->remove();

// Block #1 : Site Menu
        $block1 = $mandango->create('Model\PHPOrchestraCMSBundle\Block')
//            ->setComponent('PHPOrchestraCMSBundle:Block:show')
            ->setComponent('PHPOrchestra\CMSBundle\Controller\BlockController::showAction')  
            ->setAttributes(array('rubrique A' => 'Qui sommes-nous ?', 'rubrique B' => 'pourquoi nous choisir ?', 'rubrique C' => 'Nos agences'));
        
// Block #2 : Left Menu
        $block2 = $mandango->create('Model\PHPOrchestraCMSBundle\Block')
            ->setComponent('PHPOrchestra\CMSBundle\Controller\BlockController::fakeAction')  
            ->setAttributes(array('lien 1' => 'http://www.google.fr', 'lien 2' => 'http://www.yahoo.fr', 'lien 3' => 'http://altavista.box.co.uk'));
        
// Block #3 : News #1
        $block3 = $mandango->create('Model\PHPOrchestraCMSBundle\Block')
            ->setComponent('PHPOrchestra\CMSBundle\Controller\BlockController::fakeAction')  
            ->setAttributes(array('title' => 'News 1', 'content' => 'Donec bibendum at nibh eget imperdiet. Mauris eget justo augue. Fusce fermentum iaculis erat, sollicitudin elementum enim sodales eu. Donec a ante tortor. Suspendisse a.'));
        
// Block #4 : News #2
        $block4 = $mandango->create('Model\PHPOrchestraCMSBundle\Block')
            ->setComponent('PHPOrchestra\CMSBundle\Controller\BlockController::fakeAction')  
            ->setAttributes(array('title' => 'News #2', 'content' => 'Aliquam convallis facilisis nulla, id ultricies ipsum cursus eu. Proin augue quam, iaculis id nisi ac, rutrum blandit leo. In leo ante, scelerisque tempus lacinia in, sollicitudin quis justo. Vestibulum.'));
        
// Block #5 : News #3
        $block5 = $mandango->create('Model\PHPOrchestraCMSBundle\Block')
            ->setComponent('PHPOrchestra\CMSBundle\Controller\BlockController::showAction')  
            ->setAttributes(array('content' => 'News #3', 'content' => 'Phasellus condimentum diam placerat varius iaculis. Aenean dictum, libero in sollicitudin hendrerit, nulla mi elementum massa, eget mattis lorem enim vel magna. Fusce suscipit orci vitae vestibulum.'));
        
// Block #6 : Pub
        $block6 = $mandango->create('Model\PHPOrchestraCMSBundle\Block')
            ->setComponent('PHPOrchestra\CMSBundle\Controller\BlockController::showAction')  
            ->setAttributes(array('image' => 'mapub.jpg'));

// Block #7 : Legal mentions
        $block7 = $mandango->create('Model\PHPOrchestraCMSBundle\Block')
            ->setComponent('PHPOrchestra\CMSBundle\Controller\BlockController::showAction')  
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
            ->addBlockReferences(10, 4);

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
            ->setNodeId(1)
            ->setSiteId(1)
            ->setName('Home site avec ref Repo 0')
            ->setVersion(1)
            ->setLanguage('fr')
            ->addBlocks(array($block1, $block2, $block3, $block4, $block5, $block6, $block7))
            ->setAreas(array($area1->toArray(), $area2->toArray(), $area3->toArray()));
            
        $node->save();
        
        $nodes = $mandango->getRepository('Model\PHPOrchestraCMSBundle\Node')->createQuery();
        
        return $this->render('PHPOrchestraCMSBundle:Default:index.html.twig', array('nodes' => $nodes));
    }
    
}
