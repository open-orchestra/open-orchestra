<?php

namespace Acme\Bundle\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('AcmeBackBundle:Default:index.html.twig', array('name' => $name));
    }
}
