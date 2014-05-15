<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Noël Gilain <noel.gilain@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Controller\BackOfficeView;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use PHPOrchestra\CMSBundle\Exception\UnrecognizedCommandTypeException;

class ContentController extends Controller
{
    public function homeAction()
    {
        die();
        return $this->render('PHPOrchestraCMSBundle:BackOffice:home.html.twig');
    }
}
