<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Noël Gilain <noel.gilain@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Controller\BackOfficeView;

use Symfony\Component\HttpFoundation\JsonResponse;
use PHPOrchestra\CMSBundle\Controller\TableViewController;
use Model\PHPOrchestraCMSBundle\Content;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/content/{contentTypeId}")
 */
class ContentController extends TableViewController
{
    /**
     * (non-PHPdoc)
     * @see src/symfony2/vendor/php-orchestra/cms-bundle/PHPOrchestra/CMSBundle/Controller/PHPOrchestra
     * \CMSBundle\Controller.TableViewController::init()
     */
    public function init()
    {
        $this->setEntity('Content');
        $this->setCriteria(
            array(
                'contentType' => $this->routeParameters['contentTypeId'],
              //  'deleted' => false
            )
        );
        $this->setMainTitle('Contenus de type ' . $this->routeParameters['contentTypeId']);
    }
    
    /**
     * (non-PHPdoc)
     * @see src/symfony2/vendor/php-orchestra/cms-bundle/PHPOrchestra/CMSBundle/Controller/PHPOrchestra
     * \CMSBundle\Controller.TableViewController::setColumns()
     */
    public function setColumns()
    {
        $this->columns = array(
            array('name' => 'contentId', 'search' => 'text', 'label' => 'Id de contenu'),
            array('name' => 'shortName', 'search' => 'text', 'label' => 'Nom'),
            array('name' => 'language', 'search' => 'text', 'label' => 'Langue'),
            array('name' => 'version', 'search' => 'text', 'label' => 'Version'),
            array('name' => 'status', 'search' => 'text', 'label' => 'Statut'),
            array('button' =>'modify'),
            array('button' =>'delete')
        );
    }
    
    /**
     * (non-PHPdoc)
     * @see src/symfony2/vendor/php-orchestra/cms-bundle/PHPOrchestra/CMSBundle/Controller/PHPOrchestra
     * \CMSBundle\Controller.TableViewController::getCatalogRecords()
     */
    public function getCatalogRecords(Request $request)
    {
        $documentManager = $this->container->get('phporchestra_cms.documentmanager');
        
        $sort = array();
        if (is_array($request->get('sort'))) {
            $sort = $request->get('sort');
        }
        $sort = array_map('intval', $sort);
        
        $this->setValues(
            $documentManager->getGroupedContentsByContentId(
                $this->getCriteria(),
                (int) $request->get('start'),
                (int) $request->get('length')
            )
        );
        $this->format();
        
        return new JsonResponse(
            array(
                'success' => true,
                'data' => array(
                    'values' => $this->values,
                    'count' => count($documentManager->getGroupedContentsByContentId($this->getCriteria())),
                    'partialCount' => count($this->values)
                )
            )
        );
    }
    
    /**
     * (non-PHPdoc)
     * @see src/symfony2/vendor/php-orchestra/cms-bundle/PHPOrchestra/CMSBundle/Controller/PHPOrchestra
     * \CMSBundle\Controller.TableViewController::modifyDocumentAfterCreate($document)
     */
    protected function modifyDocumentAfterCreate($document)
    {
        $document->setContentType($this->routeParameters['contentTypeId']);
        return $document;
    }
    
    /**
     * (non-PHPdoc)
     * @see src/symfony2/vendor/php-orchestra/cms-bundle/PHPOrchestra/CMSBundle/Controller/PHPOrchestra
     * \CMSBundle\Controller.TableViewController::modifyDocumentAfterGet($document)
     */
    protected function modifyDocumentAfterGet($document)
    {
        if ($document->getStatus() != Content::STATUS_DRAFT) {
            $document->generateDraft();
        }
        
        $documentManager = $this->container->get('phporchestra_cms.documentmanager');
        $contentType = $documentManager->getDocument(
            'ContentType',
            array(
                'contentTypeId' => $document->getContentType(),
                'status' => 'published'
            )
        );
        // QUID si pas de contentType valide ???
        $document->contentTypeStructure = $contentType;
        
        return $document;
    }
    
    
    /**
     * (non-PHPdoc)
     * @see src/symfony2/vendor/php-orchestra/cms-bundle/PHPOrchestra/CMSBundle/Controller/PHPOrchestra
     * \CMSBundle\Controller.TableViewController::afterSave($document)
     */
    protected function afterSave($document)
    {
        $documentManager = $this->container->get('phporchestra_cms.documentmanager');
        
        $publishedVersions = $documentManager->getDocuments(
            'Content',
            array(
                'contentId' => $document->getContentId(),
                'status' => Content::STATUS_PUBLISHED
            )
        );
        
        foreach ($publishedVersions as $version) {
            if ($version->getId() != $document->getId()) {
                $version->setStatus(Content::STATUS_UNPUBLISHED);
                $version->save();
            }
        }
        
        // Testing if solr is running and index a content
        $indexSolr = $this->container->get('phporchestra_cms.indexsolr');
        if ($indexSolr->solrIsRunning()) {
            $indexSolr->slpitDoc($document, 'Content');
        }
        
        return array(
            'success' => true,
            'data' => $this->generateUrlValue('catalog')
        );
    }
    
    /**
     * (non-PHPdoc)
     * @see src/symfony2/vendor/php-orchestra/cms-bundle/PHPOrchestra/CMSBundle/Controller/PHPOrchestra
     * \CMSBundle\Controller.TableViewController::deleteEntity()
     */
    public function deleteEntity(Request $request, $documentId)
    {
        $documentManager = $this->get('phporchestra_cms.documentmanager');
        
        $content = $documentManager->getDocumentById('Content', $documentId);
        $contentId = $content->getContentId();
        $contentVersions = $documentManager->getDocuments('Content', array('contentId' => $contentId));
        
        foreach ($contentVersions as $contentVersion) {
            $contentVersion->markAsDeleted();
        }
        
        // Testing if solr is running and delete a content from the index
        $indexSolr = $this->get('phporchestra_cms.indexsolr');
        if ($indexSolr->solrIsRunning()) {
            $indexSolr->deleteIndex($documentId);
        }
        
        return $this->redirect(
            $this->generateUrlValue('catalog')
        );
    }
}
