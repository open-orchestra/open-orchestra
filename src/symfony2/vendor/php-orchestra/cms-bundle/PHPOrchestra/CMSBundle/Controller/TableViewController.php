<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Nicolas ANNE <nicolas.anne@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Controller;

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
    protected $key = null;
    protected $route;
    
    abstract public function edit();
    abstract public function catalog(Request $request);
    abstract public function setColumns();
    
    function __construct() {
        $this->setColumns();
    }
        
    public function getColumns()
    {
        return $this->columns;
    }
    
    public function setValues($values){
        $this->values = $values;
    }
    
    public function getValues(){
        return $this->values;
    }
    
    public function setEntity($entity){
        $this->entity = $entity;
    }
    
    public function getEntity(){
        return $this->entity;
    }
    
    public function setKey($key){
    	if(is_array($key)){
            $this->key = $key;
    	}
    }
    
    public function getKey(){
        return $this->key;
    }
    
    public function setRoute($route){
        $this->route = $route;
    }
    
    public function getRoute(){
        return $this->route;
    }

    public function generateUrlKey($url, $value){
        $id = array();
        if($this->getKey() === null){
        	$id = $value['id']->__toString();
        }
        else{
	        foreach($this->getKey() as $key){
	            if(array_key_exists($key, $value)){
	                $id[] = $value[$key];
	            }
	        }
	        $id = implode('|', $id);
        }
        return $this->generateUrl($url, array('id' => $id));
    }
    
    public function modifyButton($value){
    	if($this->getEntity() !== null){
	    	return '
	            <button data-contenttype="'.$this->generateUrlKey($this->getRoute().'_edit', $value).'" value="Modifier" class="btn btn-primary editContentType">
	               <i class="fa fa-edit"></i>
	               Modifier
	            </button>
	        ';
    	}
    	else{
            return '
                <button data-contenttype="'.$value.'" value="Modifier" class="btn btn-primary editContentType">
                   <i class="fa fa-edit"></i>
                   Modifier
                </button>
            ';
    	}
    }
	
    public function deleteButton($value){
    	if($this->getEntity() !== null){
	    	return '
	            <button data-contenttype="'.$this->generateUrlKey($this->getRoute().'_edit', $value).'" value="Supprimer" class="btn btn-danger">
	                <i class="fa fa-trash-o"></i>
	                Supprimer
	            </button>
	        ';
        }
        else{
            return '
                <button data-contenttype="'.$value.'" value="Supprimer" class="btn btn-danger">
                    <i class="fa fa-trash-o"></i>
                    Supprimer
                </button>
            ';
        }
    }
    
    public function format(){
        $values = $this->getValues();
        $columns = $this->getColumns();
        foreach($values as &$record){
        	$newRecord = array();
        	foreach($columns as $column){
        		if($column['button'] == 'modify'){
        			$newRecord[] = $this->modifyButton($record);
        		}
        		else if($column['button'] == 'delete'){
        			$newRecord[] = $this->deleteButton($record);
        		}
        		else{
        			$newRecord[] = $record[$column['name']];
        		}
        	}
        	$record = $newRecord;
        }
        $this->setValues($values);
    }

    /**
     * @Route("/edit/{id}")
     */
    public function editAction($id, Request $request){
    	
        if($this->getEntity() !== null){
            $documentManager = $this->container->get('phporchestra_cms.documentmanager');
        	if(empty($id)) {
	            $document = $documentManager->createDocument($this->getEntity());
	        }
	        else {
	            if($this->getKey() === null){
	                $document = $documentManager->getDocumentById($this->getEntity(), $id, true);
	            }
	            else{
	                $criteria = array_combine($this->getKey(), explode('|', $id));
	                $document = $documentManager->getDocument($this->getEntity(), $criteria, true);
	            }
	        }
            $form = $this->createForm(
                lcfirst($this->getEntity()),
                $document,
	            array(
	                'action' => $this->getRequest()->getUri(),
	            )
	        );
            $form->handleRequest($request);
	        if ($form->isValid()) {
	            return $this->render(
	                'PHPOrchestraCMSBundle:BackOffice/Editorial:simpleMessage.html.twig',
	                array('message' => 'Edition ok')
	            );
	        }
	        return $this->render(
	            'PHPOrchestraCMSBundle:BackOffice/TableView:form.html.twig',
	            array(
	                'form' => $form->createView()
	            )
	        );
        }
        else{
            return $this->edit($id);	
        }
    }
    /**
     * @Route("/delete/{id}")
     */
    public function deleteAction($id){}
    /**
     * @Route("/catalog")
     */
    public function catalogAction(Request $request)
    {
    	if($this->getEntity() !== null){
    		return $this->catalogEntity($request);
    	}
    	else{
    		return $this->catalog($request);
    	}
    }
    public function catalogEntity(Request $request)
    {
        $this->setRoute(preg_replace('/^(.*)_catalog$/', '$1', $request->get('_route')));

        if ($request->get('parse')) {
            $documentManager = $this->container->get('phporchestra_cms.documentmanager');
            $sort = is_array($request->get('sort')) ? array_map('intval', $request->get('sort')) : $request->get('sort');
            parse_str($request->get('criteria'), $criteria);
            array_walk($criteria, function(&$value, $key) {
                $value = new \MongoRegex('/^'.preg_quote($value).'/i');
            });
            
            $this->setValues($documentManager->getDocuments($this->getEntity(), $criteria, $sort, true, $request->get('start'), $request->get('length')));
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
        } else {
            return $this->render('PHPOrchestraCMSBundle:BackOffice:tableViewLayout.html.twig',
                array(
                    'columns' => $this->getColumns(),
                    'listUrl' => $request->get('_route'),
                    'deleteUrl' => $request->get('_route'),
                )
            );
        }
    }
}
