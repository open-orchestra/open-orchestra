<?php

namespace PHPOrchestra\CMSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use PHPOrchestra\CMSBundle\Classes\Area;

class NodesController extends Controller
{
    public function indexAction()
    {
    	$mandango = $this->container->get('mandango');

    	$nodesRepo = $mandango->getRepository('Model\PHPOrchestraCMSBundle\Node');
    	$nodesRepo->remove();

// Block #1 : Site Menu
        $block1 = $mandango->create('Model\PHPOrchestraCMSBundle\Block')
            ->setComponent('PHPOrchestraCMSBundle:Block:show')  
            ->setAttributes(array('content' => 'Site Menu'));
        
// Block #2 : Left Menu
        $block2 = $mandango->create('Model\PHPOrchestraCMSBundle\Block')
            ->setComponent('PHPOrchestraCMSBundle:Block:show')  
            ->setAttributes(array('content' => 'Left Menu'));
        
// Block #3 : News #1
        $block3 = $mandango->create('Model\PHPOrchestraCMSBundle\Block')
            ->setComponent('PHPOrchestraCMSBundle:Block:show')  
            ->setAttributes(array('content' => 'News 1'));
        
// Block #4 : News #2
        $block4 = $mandango->create('Model\PHPOrchestraCMSBundle\Block')
            ->setComponent('PHPOrchestraCMSBundle:Block:show')  
            ->setAttributes(array('content' => 'News #2'));
        
// Block #5 : News #3
        $block5 = $mandango->create('Model\PHPOrchestraCMSBundle\Block')
            ->setComponent('PHPOrchestraCMSBundle:Block:show')  
            ->setAttributes(array('content' => 'News #3'));
        
// Block #6 : Pub
        $block6 = $mandango->create('Model\PHPOrchestraCMSBundle\Block')
            ->setComponent('PHPOrchestraCMSBundle:Block:show')  
            ->setAttributes(array('content' => 'Pub'));

// Block #7 : Legal mentions
        $block7 = $mandango->create('Model\PHPOrchestraCMSBundle\Block')
            ->setComponent('PHPOrchestraCMSBundle:Block:show')  
            ->setAttributes(array('content' => 'Legal mentions'));
            
// Area 1 : Header
        $area1 = new area();
        $area1->setId('header')
            ->addBlockReferences(0, 0);
        
// Area 2-1 : Left menu
        $area21 = new area();
        $area21
            ->setId('left_menu')
            ->addBlockReferences(0, 1);
        
// Area 2-2 : Content
        $area22 = new area();
        $area22
            ->setId('content')
            ->addBlockReferences(0, 2)
            ->addBlockReferences(0, 3)
            ->addBlockReferences(0, 4);

// Area 2-3 : Skycrapper
        $area23 = new area();
        $area23
            ->setId('skycrapper')
            ->addBlockReferences(0, 5);
            
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
            ->addBlockReferences(0, 6);
            
// Node
        $node = $mandango->create('Model\PHPOrchestraCMSBundle\Node')
            ->setNode_id(1)
            ->setSite_id(1)
            ->setName('Home avec controllers de bloc')
            ->setVersion(1)
            ->setLanguage('fr')
            ->addBlocks(array($block1, $block2, $block3, $block4, $block5, $block6, $block7))
            ->setAreas(array($area1->toArray(), $area2->toArray(), $area3->toArray()));
            
        $node->save();
        
        $nodes = $mandango->getRepository('Model\PHPOrchestraCMSBundle\Node')->createQuery();
        
     //   echo '<pre>'; print_r($nodes);echo '</pre>';
        
        
        return $this->render('PHPOrchestraCMSBundle:Default:index.html.twig', array('nodes' => $nodes));
    }
}
