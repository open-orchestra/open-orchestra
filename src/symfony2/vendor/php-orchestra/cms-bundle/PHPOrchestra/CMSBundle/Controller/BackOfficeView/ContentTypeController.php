<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Noël Gilain <noel.gilain@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Controller\BackOfficeView;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Model\PHPOrchestraCMSBundle\ContentType;
use Symfony\Component\HttpFoundation\Request;

class ContentTypeController extends Controller
{
    /**
     * View the list of contentTypes
     */
    public function listAction()
    {
        $documentManager = $this->container->get('phporchestra_cms.documentmanager');
        $contentTypes = $documentManager->getDocuments('ContentType', array('deleted' => false));
        
        return $this->render(
            'PHPOrchestraCMSBundle:BackOffice/Content:tempTypeList.html.twig',
            array(
                'contentTypes' => $contentTypes
            )
        );
    }


    public function formAction($id, Request $request)
    {
        $documentManager = $this->container->get('phporchestra_cms.documentmanager');
        $contentType = $documentManager->getDocumentById('ContentType', $id);
        $lastVersion = $documentManager->getDocument('ContentType', array('contentTypeId' => $contentType->getContentTypeId()));
        
        $contentType->setVersion(1 + $lastVersion->getVersion());
        $contentType->setStatus(ContentType::STATUS_DRAFT);
        
        $form = $this->createForm(
            'contentType',
            $contentType
        );
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $node->setId(null);
            $node->setIsNew(true);
            $node->save();
            
            return $this->redirect(
                $this->generateUrl('php_orchestra_cms_bo_contentType')
            );
        }
        
        return $this->render(
            'PHPOrchestraCMSBundle:BackOffice/Content:contentTypeForm.html.twig',
            array(
                'form' => $form->createView()
            )
        );
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
