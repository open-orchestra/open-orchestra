<?php

namespace PHPOrchestra\CMSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use PHPOrchestra\CMSBundle\Classes\Area;

class NodesController extends Controller
{
	
	public function formAction(Request $request)
	{
        $mandango = $this->container->get('mandango');
        $nodesRepo = $mandango->getRepository('Model\PHPOrchestraCMSBundle\Node');
        
        $node = $mandango->create('Model\PHPOrchestraCMSBundle\Node')
            ->setNodeId(100)
            ->setSiteId(1)
            ->setName('Home avec controllers de bloc')
            ->setVersion(1)
            ->setLanguage('fr');
        
        $form = $this->createFormBuilder($node)
            ->add('nodeId', 'text')
            ->add('siteId', 'text')
            ->add('name', 'text')
            ->add('version', 'text')
            ->add('language', 'text')
            ->add('save', 'submit')
            ->getForm();

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
	
	
	
    public function addAction()
    {
    	$mandango = $this->container->get('mandango');

    	$nodesRepo = $mandango->getRepository('Model\PHPOrchestraCMSBundle\Node');
    	$nodesRepo->remove();

// Block #1 : Site Menu
        $block1 = $mandango->create('Model\PHPOrchestraCMSBundle\Block')
            ->setComponent('PHPOrchestraCMSBundle:Block:show')  
            ->setAttributes(array('rubrique A' => 'Qui sommes-nous ?', 'rubrique B' => 'pourquoi nous choisir ?', 'rubrique C' => 'Nos agences'));
        
// Block #2 : Left Menu
        $block2 = $mandango->create('Model\PHPOrchestraCMSBundle\Block')
            ->setComponent('PHPOrchestraCMSBundle:Block:show')  
            ->setAttributes(array('lien 1' => 'http://www.google.fr', 'lien 2' => 'http://www.yahoo.fr', 'lien 3' => 'http://altavista.box.co.uk'));
        
// Block #3 : News #1
        $block3 = $mandango->create('Model\PHPOrchestraCMSBundle\Block')
            ->setComponent('PHPOrchestraCMSBundle:Block:show')  
            ->setAttributes(array('title' => 'News 1', 'content' => 'Donec bibendum at nibh eget imperdiet. Mauris eget justo augue. Fusce fermentum iaculis erat, sollicitudin elementum enim sodales eu. Donec a ante tortor. Suspendisse a.'));
        
// Block #4 : News #2
        $block4 = $mandango->create('Model\PHPOrchestraCMSBundle\Block')
            ->setComponent('PHPOrchestraCMSBundle:Block:show')  
            ->setAttributes(array('title' => 'News #2', 'content' => 'Aliquam convallis facilisis nulla, id ultricies ipsum cursus eu. Proin augue quam, iaculis id nisi ac, rutrum blandit leo. In leo ante, scelerisque tempus lacinia in, sollicitudin quis justo. Vestibulum.'));
        
// Block #5 : News #3
        $block5 = $mandango->create('Model\PHPOrchestraCMSBundle\Block')
            ->setComponent('PHPOrchestraCMSBundle:Block:show')  
            ->setAttributes(array('content' => 'News #3', 'content' => 'Phasellus condimentum diam placerat varius iaculis. Aenean dictum, libero in sollicitudin hendrerit, nulla mi elementum massa, eget mattis lorem enim vel magna. Fusce suscipit orci vitae vestibulum.'));
        
// Block #6 : Pub
        $block6 = $mandango->create('Model\PHPOrchestraCMSBundle\Block')
            ->setComponent('PHPOrchestraCMSBundle:Block:show')  
            ->setAttributes(array('image' => 'mapub.jpg'));

// Block #7 : Legal mentions
        $block7 = $mandango->create('Model\PHPOrchestraCMSBundle\Block')
            ->setComponent('PHPOrchestraCMSBundle:Block:show')  
            ->setAttributes(array('Lien A' => 'Mentions légales', 'Lien B' => 'Nous contacter'));
            
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
            ->setNodeId(1)
            ->setSiteId(1)
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
