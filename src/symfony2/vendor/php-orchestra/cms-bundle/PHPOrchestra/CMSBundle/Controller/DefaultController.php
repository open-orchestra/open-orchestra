<?php

namespace PHPOrchestra\CMSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
    	$mandango = $this->container->get('mandango');
    	
    	// creating
		$site = $mandango->create('Model\PHPOrchestraCMSBundle\Site');
        $site->setDomain('www.example.org');
        $site->setLanguage('en');
        $site->save();
		
		// quering
		$sites = $mandango->getRepository('Model\PHPOrchestraCMSBundle\Site')->createQuery();

        foreach ($sites as $site)
            echo $site->getDomain() . '<br />';		
		
    	
        return $this->render('PHPOrchestraCMSBundle:Default:index.html.twig', array('name' => $name));
    }
}
