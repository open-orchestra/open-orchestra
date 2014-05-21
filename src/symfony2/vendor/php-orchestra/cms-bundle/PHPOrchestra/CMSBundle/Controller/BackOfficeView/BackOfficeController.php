<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Noël Gilain <noel.gilain@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Controller\BackOfficeView;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use PHPOrchestra\CMSBundle\Exception\UnrecognizedCommandTypeException;

class BackOfficeController extends Controller
{
    /**
     * Back Office Home Page
     */
    public function homeAction()
    {
        $documentManager = $this->container->get('phporchestra_cms.documentmanager');
        $contentTypes = $documentManager->getContentTypesInLastVersion();
        
        return $this->render(
            'PHPOrchestraCMSBundle:BackOffice:home.html.twig',
            array('contentTypes' => $contentTypes)
        );
    }
    
    /**
     * Editorial Rubric Home Page
     */
    public function editoAction()
    {
        return $this->render('PHPOrchestraCMSBundle:BackOffice/Editorial:editoHome.html.twig');
    }
    
    /**
     * Tree menu Dispatcher
     * 
     * @param string $cmd
     * @param Request $request
     */
    public function jsContextMenuDispatchAction($cmd, Request $request)
    {
        $action = '';
        $params = array();
        
        switch ($cmd)
        {
            // Nodes cmd
            case 'createNode': // Create a subpage
                $action = 'PHPOrchestraCMSBundle:Node:form';
                $params['nodeId'] = 0;
                $request->request->add(array('parentId' => $request->request->get('nodeId')));
                $request->request->remove('nodeId');
                break;
            case 'unpublishNode': // Unpublish a page
                $action = 'PHPOrchestraCMSBundle:Node:unpublish';
                break;
            case 'deleteNode': // Delete a page
                $action = 'PHPOrchestraCMSBundle:Node:delete';
                $params['nodeId'] = $request->request->get('nodeId');
                break;
            case 'moveNode': // Move a pages tree
                $action = 'PHPOrchestraCMSBundle:Node:move';
                $params['nodeId'] = $request->request->get('nodeId');
                $params['newParentId'] = $request->request->get('newParentId');
                break;
            // Templates cmd
            case 'createTemplate': // Create a template
                $action = 'PHPOrchestraCMSBundle:Template:form';
                $params['templateId'] = 0;
                $request->request->remove('nodeId');
                break;
            case 'deleteTemplate': // Delete a template
                $action = 'PHPOrchestraCMSBundle:Template:delete';
                $params['templateId'] = $request->request->get('nodeId');
                $request->request->remove('nodeId');
                break;
            // Unrecognized cmd
            default:
                throw new UnrecognizedCommandTypeException('Unrecognized command type : ' . $cmd);
        }
        
        return $this->forward($action, $params);
    }
}
