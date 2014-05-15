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
    	$params['values'] = $this->get('phporchestra_cms.siteadapter')->getValues($start=0, $end=10, $criteria=array(), $sort=array());
        return $this->forward('PHPOrchestraCMSBundle:View:list', $params);
    }
}