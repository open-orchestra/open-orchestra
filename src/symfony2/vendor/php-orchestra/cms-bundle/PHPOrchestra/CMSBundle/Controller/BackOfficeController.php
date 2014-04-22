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
    
    public function jsContextMenuDispatchAction($cmd)
    {
        $action = '';
        $params = array();
        
        switch ($cmd)
        {
            case 'createNode': // Create a subpage
                $action = 'PHPOrchestraCMSBundle:Node:form';
                break;
            case 'unpublishNode': // Unpublish a page
                $action = 'PHPOrchestraCMSBundle:Node:unpublish';
                break;
            case 'deleteNode': // Delete a page
                $action = 'PHPOrchestraCMSBundle:Node:delete';
                break;
            case 'moveNode': // Move a pages tree
                $action = 'PHPOrchestraCMSBundle:Node:move';
                break;
            default: // Unrecognized cmd
                // exception
        }
        
        return $this->forward($action, $params);
    }
}
