<?php

namespace PHPOrchestra\BlockBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of HeaderController
 *
 * @author Ayman AWAD <ayman.awad@businessdecision.com>
 */
class HeaderController extends Controller
{
    /**
     * Function to show header block
     *
     * @param string $id id of block
     * @param string $class class of block
     * @param array $block array of blocks
     */
    public function showAction($id, $class, $logo)
    {
        $response = $this->render(
            'PHPOrchestraCMSBundle:Block/Header:show.html.twig',
            array(
                'id' => $id,
                'class' => $class,
                'logo' => $logo
            )
        );
        return $response;
    }
    
    
    /**
     * Function to show header block
     *
     * @param string $id id of block
     * @param string $class class of block
     * @param array $block array of blocks
     */
    public function showBackAction($id, $class, $logo)
    {
        $response = $this->render(
            'PHPOrchestraCMSBundle:Block/Header:show.html.twig',
            array(
                'id' => $id,
                'class' => $class,
                'logo' => $logo
            )
        );
        return $response;
    }
}
