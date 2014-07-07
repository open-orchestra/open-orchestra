<?php

namespace PHPOrchestra\CMSBundle\Controller\Block;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of CarousselController
 * this controller allow to generate a caroussel
 * @author Ayman AWAD <ayman.awad@businessdecision.com>
 */
class CarrouselController extends Controller
{

    public function showAction($pictures = array(), $width, $height)
    {
        return $this->render(
            'PHPOrchestraCMSBundle:Block/Carrousel:show.html.twig',
            array(
                'pictures' => $pictures,
                'width'=> $width,
                'height'=> $height
            )
        );
    }

    public function showBackAction($pictures = array(), $width, $height)
    {
        return $this->render(
            'PHPOrchestraCMSBundle:Block/Carrousel:showBack.html.twig',
            array(
                'pictures' => $pictures,
                'width' => $width,
                'height' => $height
            )
        );
    }
}
