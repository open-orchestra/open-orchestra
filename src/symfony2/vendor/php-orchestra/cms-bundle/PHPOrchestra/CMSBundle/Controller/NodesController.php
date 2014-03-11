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
    	

// Block #1 : Site Menu
        $block1 = $mandango->create('Model\PHPOrchestraCMSBundle\Block')  
            ->setAttributes(array('content' => 'Site Menu'));
        
// Block #2 : Left Menu
        $block2 = $mandango->create('Model\PHPOrchestraCMSBundle\Block')
            ->setAttributes(array('content' => 'Left Menu'));
        
// Block #3 : News #1
        $block3 = $mandango->create('Model\PHPOrchestraCMSBundle\Block')
            ->setAttributes(array('content' => 'News 1'));
        
// Block #4 : News #2
        $block4 = $mandango->create('Model\PHPOrchestraCMSBundle\Block')
            ->setAttributes(array('content' => 'News #2'));
        
// Block #5 : News #3
        $block5 = $mandango->create('Model\PHPOrchestraCMSBundle\Block')
            ->setAttributes(array('content' => 'News #3'));
        
// Block #6 : Pub
        $block6 = $mandango->create('Model\PHPOrchestraCMSBundle\Block')
            ->setAttributes(array('content' => 'Pub'));

// Block #7 : Legal mentions
        $block7 = $mandango->create('Model\PHPOrchestraCMSBundle\Block')
            ->setAttributes(array('content' => 'Legal mentions'));
            
// Area 1 : Header
        $area1 = new area();
        $area1->setId('header')
            ->addBlockReferences(0, 1);
        
// Area 2-1 : Left menu
        $area21 = new area();
        $area21
            ->setId('left_menu')
            ->addBlockReferences(0, 2);
        
// Area 2-2 : Content
        $area22 = new area();
        $area22
            ->setId('content')
            ->addBlockReferences(0, 3)
            ->addBlockReferences(0, 4)
            ->addBlockReferences(0, 5);

// Area 2-3 : Skycrapper
        $area23 = new area();
        $area23
            ->setId('skycrapper')
            ->addBlockReferences(0, 6);
            
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
            ->addBlockReferences(0, 7);
            
// Node
        $node = $mandango->create('Model\PHPOrchestraCMSBundle\Node')
            ->setNode_id(10)
            ->setSite_id(1)
            ->setName('Home')
            ->setVersion(1)
            ->setLanguage('fr')
            ->addBlocks($block1)
            ->addBlocks($block2)
            ->addBlocks($block3)
            ->addBlocks($block4)
            ->addBlocks($block5)
            ->addBlocks($block6)
            ->addBlocks($block7)
            ->setAreas(
                    array(
                        $area1->toArray(),
                        $area2->toArray(),
                        $area3->toArray(),
                    )
            );
            
        $node->save();
        
        $nodes = $mandango->getRepository('Model\PHPOrchestraCMSBundle\Node')->createQuery();
        
     //   echo '<pre>'; print_r($nodes);echo '</pre>';
        
        
        return $this->render('PHPOrchestraCMSBundle:Default:index.html.twig', array('nodes' => $nodes));
    }
}
