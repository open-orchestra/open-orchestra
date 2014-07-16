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
        parent::init();
        
        $this->setEntity('ContentType');
        $this->setMainTitle($this->get('translator')->trans('contentTypes.mainTitle', array(), 'backOffice'));
        //$this->setCriteria(array('deleted' => false));
        $this->callback['selectLanguageName'] = function ($jsonLanguages) {
            $languages = (array) json_decode($jsonLanguages);
            $value = '';
            $currentLanguage = $this->get('phporchestra_cms.contextmanager')->getCurrentLocale();
            if (is_array($languages) && isset($languages[$currentLanguage])) {
                $value = $languages[$currentLanguage];
            }
            return $value;
        };
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
                'name' => 'contentTypeId',
                'search' => 'text',
                'label' => $translator->trans('contentTypes.list.identifier', array(), 'backOffice')
            ),
            array(
                'name' => 'name',
                'search' => 'text',
                'label' => $translator->trans('contentTypes.list.name', array(), 'backOffice'),
                'callback' => 'selectLanguageName'
            ),
            array(
                'name' => 'version',
                'search' => 'text',
                'label' =>  $translator->trans('contentTypes.list.version', array(), 'backOffice')
            ),
            array(
                'name' => 'status',
                'search' => 'text',
                'label' =>  $translator->trans('contentTypes.list.status', array(), 'backOffice')
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
            $documentManager->getContentTypesGroupedByContentTypeId(
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
                    'count' => count($documentManager->getContentTypesGroupedByContentTypeId($this->getCriteria())),
                    'partialCount' => count($this->values)
                )
            )
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
            $contentType->save();
        } else {
            $contentType = $documentManager->getDocumentById('ContentType', $documentId);
        }
        
        $documentId = (string) $contentType->getId();
        
        $form = $this->createForm('contentType', $contentType);
        
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            
            if ($contentType->new_field != '') {
                $contentType->save();
                $form = $this->createForm('contentType', $contentType);
            }
            
            if ($form->isValid() && $contentType->new_field == '') {
                $contentType->save();
                if ($contentType->getStatus() == contentType::STATUS_PUBLISHED) {
                    $this->unpublishOtherPublishedVersions(
                        $contentType->getContentTypeId(),
                        $contentType->getId()
                    );
                }
                $success = true;
                $data = $this->generateUrlValue('catalog');
            } else {
                $success = false;
                $render = $this->getRender($form, $documentId);
                $data = $render->getContent();
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

    /**
     * Get the form render
     * 
     * @param unknown_type $form
     * @param string $documentId
     */
    protected function getRender($form, $documentId)
    {
        $select = $this->render(
            'PHPOrchestraCMSBundle:BackOffice/Content:customFieldSelect.html.twig',
            array(
                'availableFields' => $this->container->getParameter('php_orchestra.custom_types'),
                'saveAction' => $this->generateUrlValue('edit', $documentId)
            )
        );
        
        $documentManager = $this->container->get('phporchestra_cms.documentmanager');
        $criteria = array('contentTypeId' => $form->get('contentTypeId')->getData());
        $versions = $documentManager->getDocuments('ContentType', $criteria, array('version' => -1), true);
        
        return $this->render(
            'PHPOrchestraCMSBundle:BackOffice/Content:contentTypeForm.html.twig',
            array(
                'form' => $form->createView(),
                'ribbon' => $this->saveButton($documentId) . $this->backButton() . $select->getContent(),
                'mainTitle' => $this->getMainTitle(),
                'tableTitle' => $this->getTableTitle(),
                'contentTypeVersions' => $versions
            )
        );
    }

    /**
     * Keep only one published version of the document $documentId
     * 
     * @param string $contentTypeId
     * @param string $documentId
     */
    protected function unpublishOtherPublishedVersions($contentTypeId, $documentId)
    {
        $documentManager = $this->container->get('phporchestra_cms.documentmanager');
        
        $versions = $documentManager->getDocuments(
            'ContentType',
            array(
                'contentTypeId' => $contentTypeId,
                'status' => contentType::STATUS_PUBLISHED
            )
        );
        
        foreach ($versions as $version) {
            if ($version->getId() != $documentId) {
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
    
    /**
     * Return a list of contentTypes alloawed for $siteId
     * 
     * @param string $siteId
     */
    public function ajaxMenuAction($language, $siteId)
    {
        $documentManager = $this->container->get('phporchestra_cms.documentmanager');
        $contentTypes = $documentManager->getContentTypesInLastVersion();
        
        $contentTypesArray = array();
        
        foreach ($contentTypes as $contentType) {
            $languages = (array) json_decode($contentType['name']);
            $name = '[' . $contentType['_id'] . ']';
            if (isset($languages[$language])) {
                $name = $languages[$language];
            }
            
            $contentTypesArray[] = array(
                'url' => $this->container->get('router')->generate(
                    'phporchestra_cms_backofficeview_content_index',
                    array(
                        'action' => 'catalog',
                        'contentTypeId' => $contentType['_id']
                    )
                ),
                'label' => htmlentities($name)
            );
        }
        
        return new JsonResponse($contentTypesArray);
    }

    /**
     * Find the contentType matching criterias, if none is found create a new one
     * Then return the edit form url
     * 
     * @param Request $request
     * @param string $mongoId
     */
    public function findForEditAction(Request $request, $mongoId)
    {
        $documentManager = $this->get('phporchestra_cms.documentmanager');
        
        $criteria = array(
            'contentTypeId' => $request->get('contentTypeId'),
            'version' => $request->get('version')
        );
        
        $contentType = $documentManager->getDocument('ContentType', $criteria);
        
        return new JsonResponse(
            array(
                'success' => true,
                'data' => $this->generateUrlValue('edit', (string) $contentType->getId())
            )
        );
    }

    /** 
     * Create a news version of contentType $mongoId
     * 
     * @param Request $request
     * @param string $id
     */
    public function duplicateAction(Request $request, $mongoId)
    {
        $documentManager = $this->get('phporchestra_cms.documentmanager');
        
        $contentType = $documentManager->getDocumentById('ContentType', $mongoId);
        $contentType->generateDraft();
        
        return new JsonResponse(
            array(
                'success' => true,
                'data' => $this->generateUrlValue('edit', (string) $contentType->getId())
            )
        );
    }
}
