<?php

namespace PHPOrchestra\CMSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BlockController extends Controller
{
    public function showAction($block)
    {
        return $this->render('PHPOrchestraCMSBundle:Block:show.html.twig', array('block' => $block));
    }
}
