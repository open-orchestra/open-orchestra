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

    function init()
    {
        parent::init();
        
        $this->setEntity('Site');
    }
    
    public function edit()
    {
    }
    
    public function catalog(Request $request)
    {
    }
        
    public function setColumns()
    {
        $this->columns = array(
            array('name' => 'domain', 'search' => 'text', 'label' => 'Domain'),
            array('name' => 'alias', 'search' => 'text', 'label' => 'Alias'),
            array('name' => 'defaultLanguage', 'search' => 'text', 'label' => 'Default Language'),
            array('name' => 'languages', 'search' => 'text', 'label' => 'Languages', 'callback' => "arrayToNewLine"),
            array('name' => 'blocks', 'search' => 'text', 'label' => 'Blocks', 'callback' => "arrayToNewLine"),
            array('button' =>'modify'),
            array('button' =>'delete'
            )
        );
    }
}
