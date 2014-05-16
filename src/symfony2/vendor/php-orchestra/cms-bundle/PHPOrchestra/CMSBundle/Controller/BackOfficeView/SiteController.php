<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Nicolas ANNE <nicolas.anne@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Controller\BackOfficeView;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SiteController extends Controller
{

    public function listAction($start=0, $end=10, $criteria=array(), $sort=array())
    {
        $documentManager = $this->container->get('phporchestra_cms.documentmanager');
        $params['values'] = $documentManager->getDocuments('Site', $criteria, $sort, true);
        return $this->forward('PHPOrchestraCMSBundle:View:list', $params);
    }
}