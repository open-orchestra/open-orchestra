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
    public function getLabels()
    {
        return array(
            'Domain',
            'Alias',
            'Default Language',
            'Languages',
            'Blocks');
    }

    public function getSearchs()
    {
        return array(
            array('name' => 'domain', 'type' => 'text'),
            array('name' => 'alias', 'type' => 'text'),
            array('name' => 'defaultLanguage', 'type' => 'text'),
            array('name' => 'languages', 'type' => 'text'),
            array('name' => 'blocks', 'type' => 'text'));
    }
    public function listAction(Request $request)
    {
        $documentManager = $this->container->get('phporchestra_cms.documentmanager');
        
        if ($request->get('parse')) {
        	parse_str($request->get('criteria'), $criteria);
        	$sort = is_array($request->get('sort')) ? array_map('intval', $request->get('sort')) : $request->get('sort');

        	$aValues = $documentManager->getDocuments('Site', $criteria, $sort, true, $request->get('start'), $request->get('length'));
            foreach($aValues as $key => $values){
            	$aValues[$key] = array(
            	   $values['domain'],
            	   $values['alias'],
            	   $values['defaultLanguage'],
            	   $values['languages'],
            	   $values['blocks'],
                );
            }        	
        	return new JsonResponse(
                array(
                    'success' => true,
                    'data' => $aValues
                )
            );
        } else {
            $params['searchs'] = $this->getSearchs();
            $params['labels'] = $this->getLabels();
            return $this->forward('PHPOrchestraCMSBundle:View:list', $params);
        }
    }
}