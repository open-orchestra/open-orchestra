<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Noël Gilain <noel.gilain@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Controller\BackOfficeView;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ContentTypeController extends Controller
{
    /**
     * View the list of contentTypes
     */
    public function listAction()
    {
        $documentManager = $this->container->get('phporchestra_cms.documentmanager');
        $contentTypes = $documentManager->getDocuments('ContentType', array('deleted' => false), array(), true);
        
        return $this->render(
            'PHPOrchestraCMSBundle:BackOffice/Content:tempTypeList.html.twig',
            array(
                'contentTypes' => $contentTypes
            )
        );
    }


    public function formAction($contentType)
    {
        
    }


    public function deleteAction($contentType)
    {
        $documentManager = $this->get('phporchestra_cms.documentmanager');
        $contentTypeVersions = $documentManager->getDocuments('ContentType', array('contentType' => $contentType));
        
        foreach ($contentTypeVersions as $contentTypeVersion) {
            $contentTypeVersion->markAsDeleted();
        }
        
        return $this->redirect(
            $this->generateUrl('php_orchestra_cms_bo_contentType')
        );
        
    }
}
