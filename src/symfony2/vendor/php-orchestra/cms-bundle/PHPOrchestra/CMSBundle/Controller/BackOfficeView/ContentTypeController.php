<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Noël Gilain <noel.gilain@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Controller\BackOfficeView;

use PHPOrchestra\CMSBundle\Controller\TableViewController;
use Model\PHPOrchestraCMSBundle\ContentType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/contenttype")
 */
class ContentTypeController extends TableViewController
{
    function __construct() {
        $this->setEntity('ContentType');
        parent::__construct();
    }
    
    public function setColumns(){
        $this->columns = array(
            array('name' => 'contentTypeId', 'search' => 'text', 'label' => 'Identifiant'),
            array('name' => 'name', 'search' => 'text', 'label' => 'Nom'),
            array('name' => 'version', 'search' => 'text', 'label' => 'Version'),
            array('name' => 'status', 'search' => 'text', 'label' => 'Statut'),
            array('name' => 'deleted', 'search' => 'text', 'label' => 'Supprimé'),
            array('button' =>'modify'),
            array('button' =>'delete')
       );
    }
    
    public function editEntity(Request $request, $id) {
        $documentManager = $this->container->get('phporchestra_cms.documentmanager');
        if (empty($id)) {
            $contentType = $documentManager->createDocument('ContentType');
        } else {
        $contentType = $documentManager->getDocumentById('ContentType', $id);
        }
        
        if ($contentType->getStatus() != ContentType::STATUS_DRAFT) {
            $contentType->generateDraft();
        }
        
        $form = $this->createForm('contentType', $contentType);
        $form->handleRequest($request);
        
        if ($contentType->new_field != '') {
            $contentType->save();
            return $this->redirect($this->generateUrl('phporchestra_cms_backofficeview_contenttype_edit', array('id' => (string)$contentType->getId())));
        } elseif ($form->isValid()) {
            $this->deleteOtherStatusVersions($contentType->getContentTypeId(), $contentType->getStatus());
            $contentType->save();
            return $this->redirect($this->generateUrl('phporchestra_cms_backofficeview_contenttype_catalog'));
        }
        
        return $this->render(
            'PHPOrchestraCMSBundle:BackOffice/Content:contentTypeForm.html.twig',
            array('form' => $form->createView())
        );
    }
    
    protected function deleteOtherStatusVersions($contentTypeId, $status)
    {
        $documentManager = $this->container->get('phporchestra_cms.documentmanager');
        
        $versions = $documentManager->getDocuments(
            'ContentType',
            array(
                'contentTypeId' => $contentTypeId,
                'status' => $status
            )
        );
        
        foreach ($versions as $version) {
            if ($version->getId() != $contentTypeId) {
                $version->delete();
            }
        }
        
        return true;
    }
    
    public function deleteEntity($request, $id)
    {
        $documentManager = $this->get('phporchestra_cms.documentmanager');
        
        $contentType = $documentManager->getDocumentById('ContentType', $id);
        $contentTypeId = $contentType->getContentTypeId();
        $contentTypeVersions = $documentManager->getDocuments('ContentType', array('contentTypeId' => $contentTypeId));
        
        foreach ($contentTypeVersions as $contentTypeVersion) {
            $contentTypeVersion->markAsDeleted();
        }
        
        return $this->redirect(
            $this->generateUrl('phporchestra_cms_backofficeview_contenttype_catalog')
        );
    }
}



/*    public function listAction()
    {
        $documentManager = $this->container->get('phporchestra_cms.documentmanager');
        $contentTypes = $documentManager->getDocuments('ContentType', array('deleted' => false));
        
        return $this->render(
            'PHPOrchestraCMSBundle:BackOffice/Content:tempTypeList.html.twig',
            array('contentTypes' => $contentTypes)
        );
    }
*/