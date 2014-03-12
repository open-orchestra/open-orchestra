<?php

namespace PHPOrchestra\CMSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class NodeController extends Controller
{
    public function showAction($nodeId)
    { 
    	$mandango = $this->container->get('mandango');
        $repository = $mandango->getRepository('Model\PHPOrchestraCMSBundle\Node');
        $query = $repository->createQuery();
        $query->criteria(array('nodeId' => (int)$nodeId));
        $node = $query->one();

        return $this->render('PHPOrchestraCMSBundle:Node:show.html.twig', array('node' => $node));
    }
}
