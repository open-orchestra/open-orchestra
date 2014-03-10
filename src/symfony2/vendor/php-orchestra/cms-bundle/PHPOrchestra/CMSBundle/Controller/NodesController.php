<?php

namespace PHPOrchestra\CMSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class NodesController extends Controller
{
    public function indexAction()
    {
    	$mandango = $this->container->get('mandango');
    	
   /* 	// creating
		$site = $mandango->create('Model\PHPOrchestraCMSBundle\Site');
        $site->setDomain('www.example.org');
        $site->setLanguage('en');
        $site->save();	
		// quering
		$sites = $mandango->getRepository('Model\PHPOrchestraCMSBundle\Site')->createQuery();
        foreach ($sites as $site)
            echo $site->getDomain() . '<br />';		
	*/	

        // Block #1 : Content #1
        $block1 = $mandango->create('Model\PHPOrchestraCMSBundle\Block');  
        $block1->setComponent('block1controller/action');
        $block1->setAttributes(array('title' => 'Content #1', 'auteur' => 'NG'));
        
        // Block #2 : Content #2
        $block2 = $mandango->create('Model\PHPOrchestraCMSBundle\Block');  
        $block2->setComponent('block2controller/action');
        $block2->setAttributes(array('title' => 'Content #2'));
/*        
        // Area 1-1 : Left menu
        $area11 = $mandango->create('Model\PHPOrchestraCMSBundle\Area');  
        $area11->setArea_id('left_menu');
        $area11->setClasses(array('left'));
        
        // Area 1-2 : Content
        $area12 = $mandango->create('Model\PHPOrchestraCMSBundle\Area');  
        $area12->setArea_id('content');
        $area12->setClasses(array('content'));
*/
        // Area 1 : Body
        $area1 = $mandango->create('Model\PHPOrchestraCMSBundle\Area');  
        $area1->setArea_id('body');
        $area1->setClasses(array('main', 'blue'));
        
        // Node
        $node = $mandango->create('Model\PHPOrchestraCMSBundle\Node');  
        $node->setNode_id(1);
        $node->setSite_id(1);
        $node->setName('Home');
        $node->setVersion(4);
        $node->setLanguage('fr');
        $node->addBlocks($block1);
        $node->addBlocks($block2);
                
        $node->save();
        
        $nodes = $mandango->getRepository('Model\PHPOrchestraCMSBundle\Node')->createQuery();
        
        return $this->render('PHPOrchestraCMSBundle:Default:index.html.twig', array('nodes' => $nodes));
    }
}
