<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Nicolas ANNE <nicolas.anne@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Controller\BackOfficeView;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class SiteController extends Controller
{

	public function listAction(Request $request)
    {
    	if ($request->get('parse')) {
            return new JsonResponse(
                array(
                    'success' => true,
                    'data' => $this->get('phporchestra_cms.siteadapter')->getValues($request->get('start'), $request->get('end'), $request->get('criteria'), $request->get('sort'))
                )
            );
        } else {
	        $params['searchs'] = $this->get('phporchestra_cms.siteadapter')->getSearchs();
	        $params['labels'] = $this->get('phporchestra_cms.siteadapter')->getLabels();
        	return $this->forward('PHPOrchestraCMSBundle:View:list', $params);
        }
    }
}