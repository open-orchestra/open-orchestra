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
    	

// Block #1 : Content #1
        $block1 = $mandango->create('Model\PHPOrchestraCMSBundle\Block')  
            ->setComponent('block1controller/action')
            ->setAttributes(array('title' => 'Content #1', 'auteur' => 'NG'));
        
// Block #2 : Content #2
        $block2 = $mandango->create('Model\PHPOrchestraCMSBundle\Block')
            ->setComponent('block2controller/action')
            ->setAttributes(array('title' => 'Content #2'));
        
// Area 1-1 : Left menu
        $area11 = new area();
        $area11
            ->setId('left_menu')
            ->addClass('left')
            ->addBlockReferences(0, 1);
        
// Area 1-2 : Content
        $area12 = new area();
        $area12
            ->setId('content')
            ->addClass('content')
            ->addBlockReferences(0, 2);
        
// Area 1 : Body
        $area1 = new area();
        $area1
            ->setId('body')
            ->addClass('main')
            ->addClass('blue')
            ->addSubArea($area11)
            ->addSubArea($area12);
// Node
        $node = $mandango->create('Model\PHPOrchestraCMSBundle\Node')
            ->setNode_id(1)
            ->setSite_id(1)
            ->setName('Home')
            ->setVersion(4)
            ->setLanguage('fr')
            ->addBlocks($block1)
            ->addBlocks($block2)
            ->setAreas(array($area1->toArray()));
            
        $node->save();
        
        $nodes = $mandango->getRepository('Model\PHPOrchestraCMSBundle\Node')->createQuery();
        
     //   echo '<pre>'; print_r($nodes);echo '</pre>';
        
        
        return $this->render('PHPOrchestraCMSBundle:Default:index.html.twig', array('nodes' => $nodes));
    }
}
