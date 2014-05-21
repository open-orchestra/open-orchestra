<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Nicolas ANNE <nicolas.anne@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Controller\BackOfficeView;

use Symfony\Component\HttpFoundation\Request;
use PHPOrchestra\CMSBundle\Controller\ViewController;

class SiteController extends ViewController
{

	public function format(){
		$aValues = $this->getValues();
        foreach($aValues as &$values){
        	$values = array($values['domain'],
        	   $values['alias'],
        	   implode('<br />', explode(',', $values['defaultLanguage'])),
        	   $values['languages'],
        	   implode('<br />', explode(',', $values['blocks'])),
               parent::modifyButton($values['siteId']),
               parent::deleteButton($values['siteId']));
        }
        $this->setValues($aValues);
    }
    
    public function listAction(Request $request)
    {
    	$this->setEntity('Site');
    	$this->setSearchs(array(
            array('name' => 'domain', 'type' => 'text'),
            array('name' => 'alias', 'type' => 'text'),
            array('name' => 'defaultLanguage', 'type' => 'text'),
            array('name' => 'languages', 'type' => 'text'),
            array('name' => 'blocks', 'type' => 'text'),
            '',
            ''));
    	$this->setLabels(array(
            'Domain',
            'Alias',
            'Default Language',
            'Languages',
            'Blocks',
	    	'',
	    	''));
    	return parent::listActionEntity($request);
    }
}