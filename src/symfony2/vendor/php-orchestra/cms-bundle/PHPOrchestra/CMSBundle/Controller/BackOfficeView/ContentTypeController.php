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
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/contenttype")
 */
class ContentTypeController extends TableViewController
{
    
    /**
     * (non-PHPdoc)
     * @see src/symfony2/vendor/php-orchestra/cms-bundle/PHPOrchestra/CMSBundle/Controller/PHPOrchestra
     * \CMSBundle\Controller.TableViewController::init()
     */
    public function init()
    {
        $this->setEntity('ContentType');
    }
    
    
    /**
     * (non-PHPdoc)
     * @see src/symfony2/vendor/php-orchestra/cms-bundle/PHPOrchestra/CMSBundle/Controller/PHPOrchestra
     * \CMSBundle\Controller.TableViewController::setColumns()
     */
    public function setColumns()
    {
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
    
    
    /**
     * (non-PHPdoc)
     * @see src/symfony2/vendor/php-orchestra/cms-bundle/PHPOrchestra/CMSBundle/Controller/PHPOrchestra
     * \CMSBundle\Controller.TableViewController::editEntity()
     */
    public function editEntity(Request $request, $documentId)
    {
        $documentManager = $this->container->get('phporchestra_cms.documentmanager');
        
        if (empty($documentId)) {
            $contentType = $documentManager->createDocument('ContentType');
        } else {
            $contentType = $documentManager->getDocumentById('ContentType', $documentId);
        }
        
        if ($contentType->getStatus() != ContentType::STATUS_DRAFT) {
            $contentType->generateDraft();
        }
        
        $form = $this->createForm('contentType', $contentType);
        
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($contentType->new_field != '') {
                $contentType->save();
                $form = $this->createForm('contentType', $contentType); // Toujours utile ?
            }
            if ($contentType->new_field != '' || !$form->isValid()) {
                $render = $this->getRender($form, $documentId);
                $success = false;
                $data = $render->getContent();
            } else {
                $this->deleteOtherStatusVersions($contentType->getContentTypeId(), $contentType->getStatus());
                $contentType->save();
                $success = true;
                $data = $this->generateUrlValue('catalog');
            }
            return new JsonResponse(
                array(
                    'success' => $success,
                    'data' => $data
                )
            );
        }
        
        return $this->getRender($form, $documentId);
    }
    
    protected function getRender($form, $documentId)
    {
        $select = $this->render(
            'PHPOrchestraCMSBundle:BackOffice/Content:customFieldSelect.html.twig',
            array('availableFields' => $this->container->getParameter('php_orchestra.custom_types'))
        );
        
        return $this->render(
            'PHPOrchestraCMSBundle:BackOffice/Content:contentTypeForm.html.twig',
            array(
                'form' => $form->createView(),
                'ribbon' => $this->saveButton($documentId) . $this->backButton() . $select->getContent()
            )
        );
    }
    
    public function genericButton($data, $action, $label, $class, $icon){
        if($this->getEntity() !== null){
            $data = $this->generateUrlValue($action, $data);
        }
        $render = $this->render(
            $this->buttonTwig,
            array(
                'data' => $data,
                'label' => $label,
                'class' => $class,
                'icon' => $icon
            )
        );
        return $render->getContent();       
    }
    
    /**
     * Keep only one version of the status $status for the document $contentTypeId
     * 
     * @param string $contentTypeId
     * @param string $status
     */
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
    
    /**
     * (non-PHPdoc)
     * @see src/symfony2/vendor/php-orchestra/cms-bundle/PHPOrchestra/CMSBundle/Controller/PHPOrchestra
     * \CMSBundle\Controller.TableViewController::deleteEntity()
     */
    public function deleteEntity(Request $request, $documentId)
    {
        $documentManager = $this->get('phporchestra_cms.documentmanager');
        
        $contentType = $documentManager->getDocumentById('ContentType', $documentId);
        $contentTypeId = $contentType->getContentTypeId();
        $contentTypeVersions = $documentManager->getDocuments('ContentType', array('contentTypeId' => $contentTypeId));
        
        foreach ($contentTypeVersions as $contentTypeVersion) {
            $contentTypeVersion->markAsDeleted();
        }
        
        return $this->redirect(
            $this->generateUrlValue('catalog')
        );
    }
}
