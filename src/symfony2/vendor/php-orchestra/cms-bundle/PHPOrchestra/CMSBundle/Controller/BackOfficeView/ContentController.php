<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Noël Gilain <noel.gilain@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Controller\BackOfficeView;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ContentController extends Controller
{
    /**
     * View the list of a specific contentType
     */
    public function listAction($contentType)
    {
        $documentManager = $this->container->get('phporchestra_cms.documentmanager');
        $contents = $documentManager->getDocuments('Content', array('contentType' => $contentType), array(), true);
        
        return $this->render(
            'PHPOrchestraCMSBundle:BackOffice/Content:tempList.html.twig',
            array(
                'contentType' => $contentType,
                'contents' => $contents
            )
        );
    }
    
    public function formAction()
    {
        die();
        return $this->render('PHPOrchestraCMSBundle:BackOffice:home.html.twig');
    }
}
