<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Nicolas ANNE <nicolas.anne@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use PHPOrchestra\CMSBundle\Exception\UnrecognizedCommandTypeException;

class ViewController extends Controller
{
    public function listAction($values)
    {
        return $this->render('PHPOrchestraCMSBundle:BackOffice:viewLayout.html.twig');
    }
}
