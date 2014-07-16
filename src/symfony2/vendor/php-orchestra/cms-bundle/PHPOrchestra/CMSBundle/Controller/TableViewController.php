<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Nicolas ANNE <nicolas.anne@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Controller;

use PHPOrchestra\CMSBundle\Exception\NonExistingFieldException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

abstract class TableViewController extends Controller
{
    
    protected $columns = array();
    protected $values = array();
    protected $entity = null;
    protected $criteria = array();
    protected $sort = array();
    protected $key = null;
    protected $callback = array();
    protected $buttonTwig = 'PHPOrchestraCMSBundle:BackOffice/TableView:button.html.twig';
    protected $routeParameters = array();
    protected $mainTitle = '';
    protected $tableTitle = '';
    protected $recordPrimaryKey = 'id';
    
    abstract public function setColumns();
    
    public function __construct()
    {
        $this->callback['arrayToNewLine'] = function ($value) {
            return implode('<br />', $value);
        };
        $this->callback['replaceComaByNewLine'] = function ($value) {
            return implode('<br />', explode(',', $value));
        };
    }
        
    public function init()
    {
        $request = $this->container->get('request');
        $this->routeParameters = $request->attributes->get('_route_params');
        
        $this->setColumns();
    }

    public function getColumns()
    {
        return $this->columns;
    }
    
    public function setValues($values)
    {
        $this->values = $values;
    }
    
    public function getValues()
    {
        return $this->values;
    }
    
    public function setEntity($entity)
    {
        $this->entity = $entity;
    }
    
    public function getEntity()
    {
        return $this->entity;
    }
    
    /**
     * Set the primary key of records shown in list
     * 
     * @param string $key
     */
    public function setRecordPrimaryKey($key)
    {
        $this->recordPrimaryKey = $key;
    }
    
    /**
     * Get the primary key of records shown in list
     */
    public function getRecordPrimaryKey()
    {
        return $this->recordPrimaryKey;
    }
    
    public function setCriteria($criteria)
    {
        $this->criteria = $criteria;
    }
    
    public function getCriteria()
    {
        return $this->criteria;
    }
        
    public function setSort($sort)
    {
        $this->sort = $sort;
    }
    
    public function getSort()
    {
        return $this->sort;
    }
    
    public function setKey($key)
    {
        if (is_array($key)) {
            $this->key = $key;
        }
    }
    
    public function getKey()
    {
        return $this->key;
    }
    
    /**
     * Set main title
     * 
     * @param string $title
     */
    public function setMainTitle($title)
    {
        $this->mainTitle = $title;
    }
    
    /**
     * Get main title
     */
    public function getMainTitle()
    {
        if ($this->mainTitle != '') {
            return $this->mainTitle;
        } else {
            return $this->getEntity();
        }
    }
    
    /**
     * Set table title
     * 
     * @param string $title
     */
    public function setTableTitle($title)
    {
        $this->tableTitle = $title;
    }
    
    /**
     * Get table title
     */
    public function getTableTitle()
    {
        return $this->tableTitle;
    }
    
    public function setButtonTwig($buttonTwig)
    {
        $this->buttonTwig = $buttonTwig;
    }
    
    public function getButtonTwig($buttonTwig)
    {
        return $this->buttonTwig;
    }
    
    /**
     * @Route("/{action}/{id}")
     */
    public function indexAction(Request $request, $action, $id = null)
    {
        $this->init();
        
        return call_user_func(array($this, $action.'Action'), $request, $id);
    }
    
    public function editAction(Request $request, $id = null)
    {
        $this->setTableTitle($this->get('translator')->trans('tableView.edition', array(), 'backOffice'));
        
        if ($this->getEntity() !== null) {
            return $this->editEntity($request, $id);
        } else {
            return $this->edit($id);
        }
    }

    public function deleteAction(Request $request, $id = null)
    {
        if ($this->getEntity() !== null) {
            return $this->deleteEntity($request, $id);
        } else {
            return $this->edit($id);
        }
    }

    public function catalogAction(Request $request)
    {
        $this->setTableTitle($this->get('translator')->trans('tableView.list', array(), 'backOffice'));
        
        if ($this->getEntity() !== null) {
            return $this->catalogEntity($request);
        } else {
            return $this->catalog($request);
        }
    }
    
    
    public function generateUrlValue($action, $id = false)
    {
        $parameters = $this->routeParameters;
        $parameters['action'] = $action;
        if (!empty($id)) {
            $parameters['id'] = $id;
        } else {
            unset($parameters['id']);
        }
        return $this->generateUrl($this->get('request')->get('_route'), $parameters);
    }
    
    public function genericButton($data, $action, $label, $class, $icon)
    {
        if ($this->getEntity() !== null) {
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
    
    public function modifyButton($value)
    {
        return $this->genericButton(
            $value,
            'edit',
            $this->get('translator')->trans('tableView.modify', array(), 'backOffice'),
            'btn btn-primary redirect',
            'fa fa-edit'
        );
    }
    public function deleteButton($value)
    {
        return $this->genericButton(
            $value,
            'delete',
            $this->get('translator')->trans('tableView.delete', array(), 'backOffice'),
            'btn btn-danger delete',
            'fa fa-trash-o'
        );
    }
    public function addButton()
    {
        return $this->genericButton(
            '',
            'edit',
            $this->get('translator')->trans('tableView.add', array(), 'backOffice'),
            'btn btn-small btn-ribbon bt-primary redirect',
            'fa fa-plus'
        );
    }
    public function saveButton($value)
    {
        return $this->genericButton(
            $value,
            'edit',
            $this->get('translator')->trans('tableView.save', array(), 'backOffice'),
            'btn btn-small btn-ribbon bt-primary submit',
            'fa fa-save'
        );
    }
    public function backButton()
    {
        return $this->genericButton(
            '',
            'catalog',
            $this->get('translator')->trans('tableView.back', array(), 'backOffice'),
            'btn btn-small btn-ribbon bt-primary redirect',
            'fa fa-undo'
        );
    }
    
    public function format()
    {
        $values = $this->getValues();
        $columns = $this->getColumns();
        foreach ($values as &$record) {
            $newRecord = array();
            foreach ($columns as $column) {
                if (array_key_exists('button', $column)) {
                    if ($column['button'] == 'modify') {
                        $newRecord[] = $this->modifyButton($record[$this->getRecordPrimaryKey()]->__toString());
                    } elseif ($column['button'] == 'delete') {
                        $newRecord[] = $this->deleteButton($record[$this->getRecordPrimaryKey()]->__toString());
                    }
                } else {
                    if (!array_key_exists($column['name'], $record)) {
                        throw new NonExistingFieldException(
                            'The field ' . $column['name'] . ' does not exist in TableViewController.php'
                        );
                    }
                    if (array_key_exists('callback', $column)) {
                        $newRecord[] = $this->callback[$column['callback']]($record[$column['name']]);
                    } else {
                        $newRecord[] = $record[$column['name']];
                    }
                }
            }
            $record = $newRecord;
        }
        $this->setValues($values);
    }

    public function editEntity(Request $request, $id)
    {
        $document = $this->getDocument($id);
        $document = $this->modifyDocumentAfterGet($document);
        
        $form = $this->createEditForm($request, $document);
        
        return $this->editRender($request, $id, $form, $document);
    }

    /**
     * Get an existing document by its $mongoId or create a new one
     * 
     * @param string $mongoId
     */
    protected function getDocument($mongoId)
    {
        $documentManager = $this->container->get('phporchestra_cms.documentmanager');
        if (empty($mongoId)) {
            $document = $documentManager->createDocument($this->getEntity());
            $document = $this->modifyDocumentAfterCreate($document);
        } else {
            if ($this->getKey() === null) {
                $document = $documentManager->getDocumentById($this->getEntity(), $mongoId);
            } else {
                $criteria = array_combine($this->getKey(), explode('|', $mongoId));
                $document = $documentManager->getDocument($this->getEntity(), $criteria);
            }
        }
        return $document;
    }

    /**
     * Allow to modify a loaded $document after its creation
     * 
     * @param unknown_type $document of $this->entity type
     */
    protected function modifyDocumentAfterCreate($document)
    {
        return $document;
    }

    /**
     * Allow to modify a loaded $document before passing it to the form
     * 
     * @param unknown_type $document of $this->entity type
     */
    protected function modifyDocumentAfterGet($document)
    {
        return $document;
    }

    /**
     * Return the edit form
     * 
     * @param $document
     */
    protected function createEditForm($request, $document)
    {
        if ($request->query->get('refresh') !== null) {
            $name = lcfirst($this->getEntity());
            $form = $this->createForm(
                $name,
                $request->query->get($name),
                array(
                   'action' => $this->getRequest()->getUri(),
                )
            );
        } else {
            $form = $this->createForm(
                lcfirst($this->getEntity()),
                $document,
                array(
                   'action' => $this->getRequest()->getUri(),
                )
            );
        }
        
        return $form;
    }

    /**
     * Factorize Render for json and no json response
     * 
     * @param Request $request
     * @param string $mongoId
     * @param unknown_type $form
     */
    protected function getRender($mongoId, $form)
    {
        return $this->render(
            'PHPOrchestraCMSBundle:BackOffice/TableView:form.html.twig',
            array(
                'form' => $form->createView(),
                'mainTitle' => $this->getMainTitle(),
                'tableTitle' => $this->getTableTitle(),
                'ribbon' => $this->saveButton($mongoId) . $this->backButton()
            )
        );
    }
    
    /**
     * Render the view, either edit form or catalog list
     * 
     * @param Request $request
     * @param string $mongoId
     * @param unknown_type $form
     * @param unknown_type $document of $this->entity type
     */
    protected function editRender($request, $mongoId, $form, $document)
    {
        if ($request->query->get('refresh') !== null) {
            $render = $this->render(
                'PHPOrchestraCMSBundle:Form:form.html.twig',
                array('form' => $form->createView())
            );
            return new JsonResponse(
                array(
                    'success' => true,
                    'data' => $render->getContent()
                )
            );
        } else {
            if ($request->getMethod() == 'POST') {
                $form->handleRequest($request);
                $success = false;
                if ($form->isValid()) {
                    $document = $this->modifyDocumentBeforeSave($document);
                    $document->save();
                    $saveResult = $this->afterSave($document);
                    $success = $saveResult['success'];
                    $data = $saveResult['data'];
                } else {
                    $data = $this->getRender($mongoId, $form)->getContent();
                }
                return new JsonResponse(
                    array(
                        'success' => $success,
                        'data' => $data
                    )
                );
            }
            
            return $this->getRender($mongoId, $form);
        }
    }
    
    /**
     * Allows to modify document after form validation and before saving it
     * 
     * @param unknown_type $document of $this->entity type
     */
    protected function modifyDocumentBeforeSave($document)
    {
        return $document;
    }
    
    /**
     * Allows to do some additionnal stuff after saving the $document
     * 
     * @param unknown_type $document of $this->entity type
     */
    protected function afterSave($document)
    {
        return array(
            'success' => true,
            'data' => $this->generateUrlValue('catalog')
        );
    }
    
    public function deleteEntity(Request $request, $id)
    {
        $documentManager = $this->container->get('phporchestra_cms.documentmanager');
        if (!empty($id)) {
            if ($this->getKey() === null) {
                $document = $documentManager->getDocumentById($this->getEntity(), $id);
            } else {
                $criteria = array_combine($this->getKey(), explode('|', $id));
                $document = $documentManager->getDocument($this->getEntity(), $criteria);
            }
            $document->delete();
        }
        
        return $this->redirect($this->generateUrlValue('catalog'));
    }
    
    public function catalogEntity(Request $request)
    {
        if ($request->get('parse')) {
            return $this->getCatalogRecords($request);
        } else {
            return $this->render(
                'PHPOrchestraCMSBundle:BackOffice:TableView/tableViewLayout.html.twig',
                array(
                    'columns' => $this->getColumns(),
                    'listUrl' => $this->generateUrlValue('catalog'),
                    'order' => array(array(1, 'desc')),
                    'mainTitle' => $this->getMainTitle(),
                    'tableTitle' => $this->getTableTitle(),
                    'ribbon' => $this->addButton()
                )
            );
        }
    }
    
    /**
     * Get the records to show in the list
     * 
     * @param Request $request
     */
    public function getCatalogRecords(Request $request)
    {
        $documentManager = $this->container->get('phporchestra_cms.documentmanager');
        $sort = is_array($request->get('sort')) ? $request->get('sort') : $this->sort;
        $sort = array_map('intval', $sort);
        
        parse_str($request->get('criteria'), $criteria);
        $criteria = array_merge($this->criteria, $criteria);
        array_walk(
            $criteria,
            function (&$value, $key) {
                $value = new \MongoRegex('/'.preg_quote($value).'/i');
            }
        );
        
        $this->setValues(
            $documentManager->getDocuments(
                $this->getEntity(),
                $criteria,
                $sort,
                true,
                $request->get('start'),
                $request->get('length')
            )
        );
        $this->format();
        
        $count = $documentManager->getDocumentsCount($this->getEntity());
        
        $partialCount = $documentManager->getDocumentsCount($this->getEntity(), $criteria);
        
        return new JsonResponse(
            array(
                'success' => true,
                'data' => array(
                    'values' => $this->values,
                    'count' => $count,
                    'partialCount' => $partialCount
                )
            )
        );
    }
}
