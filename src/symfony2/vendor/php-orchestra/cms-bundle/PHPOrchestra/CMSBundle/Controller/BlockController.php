<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Noël Gilain <noel.gilain@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BlockController extends Controller
{
    /**
     * Render a block
     * 
     * @param String[] $block array containing custom attributes
     */
    public function showAction($block)
    {
        return $this->render('PHPOrchestraCMSBundle:Block:show.html.twig', array('block' => $block));
    }
}
