<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Nicolas ANNE <nicolas.anne@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Controller\BackOfficeView;

use Symfony\Component\HttpFoundation\Request;
use PHPOrchestra\CMSBundle\Controller\TableViewController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/site")
 */
class SiteController extends TableViewController
{

    function __construct() {
    	$this->setEntity('Site');
    	parent::__construct();
    }
	
    public function edit(){
    }
    
    public function catalog(Request $request){
    }
        
    public function setColumns(){
        $this->columns = array(
            array('name' => 'domain', 'search' => 'text', 'button' =>'', 'label' => 'Domain'),
            array('name' => 'alias', 'search' => 'text', 'button' =>'', 'label' => 'Alias'),
            array('name' => 'defaultLanguage', 'search' => 'text', 'button' =>'', 'label' => 'Default Language'),
            array('name' => 'languages', 'search' => 'text', 'button' =>'', 'label' => 'Languages'),
            array('name' => 'blocks', 'search' => 'text', 'button' =>'', 'label' => 'Blocks'),
            array('name' => '', 'search' => '', 'button' =>'modify', 'label' => ''),
            array('name' => '', 'search' => '', 'button' =>'delete', 'label' => '')
       );
    }
}