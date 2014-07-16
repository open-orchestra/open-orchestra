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
        parent::init();
        
        $this->setEntity('Content');
        
        $this->setMainTitle(
            $this->get('translator')->trans(
                'contents.mainTitle%contentType%',
                array('contentType' => $this->routeParameters['contentTypeId']),
                'backOffice'
            )
        );
        
        $this->setCriteria(
            array(
                'contentType' => $this->routeParameters['contentTypeId'],
              //  'deleted' => false
            )
        );
    }
    
    /**
     * (non-PHPdoc)
     * @see src/symfony2/vendor/php-orchestra/cms-bundle/PHPOrchestra/CMSBundle/Controller/PHPOrchestra
     * \CMSBundle\Controller.TableViewController::setColumns()
     */
    public function setColumns()
    {
        $translator = $this->get('translator');
        
        $this->columns = array(
            array(
                'name' => 'contentId',
                'search' => 'text',
                'label' => $translator->trans('contents.list.contentId', array(), 'backOffice')
            ),
            array(
                'name' => 'shortName',
                'search' => 'text',
                'label' => $translator->trans('contents.list.label', array(), 'backOffice')
            ),
            array(
                'name' => 'language',
                'search' => 'text',
                'label' => $translator->trans('contents.list.language', array(), 'backOffice')
            ),
            array(
                'name' => 'version',
                'search' => 'text',
                'label' => $translator->trans('contents.list.version', array(), 'backOffice')
            ),
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
     * \CMSBundle\Controller.TableViewController::getRender()
     */
    protected function getRender($mongoId, $form)
    {
        $availableLanguages = $this->container->getParameter('php_orchestra.languages.availables');
        
        $documentManager = $this->container->get('phporchestra_cms.documentmanager');
        $criteria = array(
            'contentId' => $form->get('contentId')->getData(),
            'language' => $form->get('language')->getData(),
            'contentType' => $form->get('contentType')->getData(),
        );
        $versions = $documentManager->getDocuments('Content', $criteria, array('version' => -1), true);
        
        return $this->render(
            'PHPOrchestraCMSBundle:BackOffice/Content:contentForm.html.twig',
            array(
                'form' => $form->createView(),
                'mainTitle' => $this->getMainTitle(),
                'tableTitle' => $this->getTableTitle(),
                'ribbon' => $this->saveButton($mongoId) . $this->backButton(),
                'availableLanguages' => $availableLanguages,
                'contentVersions' => $versions
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

        /*$soft = $this->get('phporchestra_cms.indexHelper');
        $soft->index($document, 'Content');*/
        
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

        /*$soft = $this->get('phporchestra_cms.indexHelper');
        $soft->deleteIndex($contentId);*/
        
        return $this->redirect(
            $this->generateUrlValue('catalog')
        );
    }
    
    /**
     * Find the content matching criterias, if none is found create a new one
     * Then return the edit form url
     * 
     * @param Request $request
     * @param string $mongoId
     */
    public function findForEditAction(Request $request, $mongoId)
    {
        $contentTypeId = $request->get('contentTypeId');
        $contentId = $request->get('contentId');
        $language = $request->get('language');
        $version = $request->get('version');
        
        $documentManager = $this->get('phporchestra_cms.documentmanager');
        
        $criteria = array(
            'contentType' => $contentTypeId,
            'contentId' => $contentId,
            'language' => $language
        );
        
        if ($version != 0) {
            $criteria['version'] = $version;
        }
        
        $content = $documentManager->getDocument('Content', $criteria);
        
        if (count($content) == 0) {
            $content = $documentManager->createDocument('Content');
            $content->setContentType($contentTypeId);
            $content->setContentId($contentId);
            $content->setLanguage($language);
            $content->save();
        }
        
        return new JsonResponse(
            array(
                'success' => true,
                'data' => $this->generateUrlValue('edit', (string) $content->getId())
            )
        );
    }
    
    /**
     * Create a news version of content $mongoId
     * 
     * @param Request $request
     * @param string $mongoId
     */
    public function duplicateAction(Request $request, $mongoId)
    {
        $documentManager = $this->get('phporchestra_cms.documentmanager');
        
        $content = $documentManager->getDocumentById('Content', $mongoId);
        $content->generateDraft();
        
        return new JsonResponse(
            array(
                'success' => true,
                'data' => $this->generateUrlValue('edit', (string) $content->getId())
            )
        );
    }
}
