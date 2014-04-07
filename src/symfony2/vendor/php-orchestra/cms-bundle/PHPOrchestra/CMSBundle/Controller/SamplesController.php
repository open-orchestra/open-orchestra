<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Noël Gilain <noel.gilain@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use PHPOrchestra\CMSBundle\Model\Area;

class SamplesController extends Controller
{
    
    /**
     * Render a sampleblock
     * 
     * @param String[] $block array containing custom attributes
     */
    public function sampleShowAction($rubA, $rubB, $rubC, $_page_parameters)
    {
        $datetime = time();
        
        $response = $this->render('PHPOrchestraCMSBundle:Samples:blocSample.html.twig', array('rubA' => $rubA, 'rubB' => $rubB, 'rubC' => $rubC, 'parameters' => $_page_parameters, 'datetime' => $datetime));
        
        $response->setPublic();
        $response->setSharedMaxAge(60);
        $response->headers->addCacheControlDirective('must-revalidate', true);
                
        return $response;
    }
    
    
    /**
     * Test purpose : inject a sample Node in MongoDB
     * 
     * @return Response
     */
    public function addSampleAction()
    {
        $mandango = $this->container->get('mandango');

//        $nodesRepo = $mandango->getRepository('Model\PHPOrchestraCMSBundle\Node');
//        $nodesRepo->remove();

// Block #1 : Site Menu
        $block1 = $mandango->create('Model\PHPOrchestraCMSBundle\Block')
            ->setComponent('PHPOrchestraCMSBundle:Samples:sampleShow')  
            ->setAttributes(array('rubA' => 'Qui sommes-nous ?', 'rubB' => 'pourquoi nous choisir ?', 'rubC' => 'Nos agences'));
        
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
            ->setNodeId('move_sample')
            ->setSiteId(1)
            ->setName('Move sample')
            ->setVersion(1)
            ->setparentId(0)
            ->setAlias('sampleblock')
            ->setLanguage('fr')
            ->setNodeType('module')
            ->addBlocks(array($block1, $block2, $block3, $block4, $block5, $block6, $block7))
            ->setAreas(array($area1->toArray(), $area2->toArray(), $area3->toArray()));
            
        $node->save();
        
        $nodes = $mandango->getRepository('Model\PHPOrchestraCMSBundle\Node')->createQuery();
        
        return $this->render('PHPOrchestraCMSBundle:Samples:show.html.twig', array('nodes' => $nodes));
    }
    
}
