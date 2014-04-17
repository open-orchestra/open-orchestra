<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Noël Gilain <noel.gilain@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BackOfficeController extends Controller
{
    public function homeAction()
    {
        return $this->render('PHPOrchestraCMSBundle:BackOffice:home.html.twig');
    }
}