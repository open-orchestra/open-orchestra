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
    protected $callback = array();
    abstract public function setColumns();
    
    function __construct() {
        $this->setColumns();
        $this->callback['replaceComaByNewLine'] = create_function('$value', 'return implode("<br />", explode(",", $value));');
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

    /**
     * @Route("/edit/{id}")
     */
    public function editAction(Request $request, $id=null){
        $this->setRoute(preg_replace('/^(.*)_edit$/', '$1', $request->get('_route')));
    	if($this->getEntity() !== null){
            return $this->editEntity($request, $id);
        }
        else{
            return $this->edit($id);
        }
    }
    /**
     * @Route("/save/{id}")
     */
    public function saveAction(Request $request, $id=null){
        $this->setRoute(preg_replace('/^(.*)_save$/', '$1', $request->get('_route')));
    	if($this->getEntity() !== null){
            return $this->saveEntity($request, $id);
        }
        else{
            return $this->save($id);    
        }
    }
    /**
     * @Route("/delete/{id}")
     */
    public function deleteAction(Request $request, $id=null){
        $this->setRoute(preg_replace('/^(.*)_delete$/', '$1', $request->get('_route')));
    	if($this->getEntity() !== null){
            return $this->deleteEntity($request, $id);
        }
        else{
            return $this->edit($id);    
        }
    }
     /**
     * @Route("/catalog")
     */
    public function catalogAction(Request $request)
    {
        $this->setRoute(preg_replace('/^(.*)_catalog$/', '$1', $request->get('_route')));
        if($this->getEntity() !== null){
            return $this->catalogEntity($request);
        }
        else{
            return $this->catalog($request);
        }
    }
    
    
    public function generateUrlValue($url, $value){
    	if(!empty($value)){
            return $this->generateUrl($url, array('id' => $value));
    	}
    	else{
    		return $this->generateUrl($url);
    	}
    }
    
    public function genericButton($value, $path, $label, $classBtn, $class){
        if($this->getEntity() !== null){
            return '
                <button data-parameter="'.$this->generateUrlValue($this->getRoute().'_'.$path, $value).'" value="'.$label.'" class="'.$classBtn.'">
                   <i class="'.$class.'"></i>&nbsp;'.$label.'
                </button>
            ';
        }
        else{
            return '
                <button data-parameter="'.$value.'" value="'.$label.'" class="btn '.$classBtn.'">
                   <i class="'.$class.'"></i>&nbsp;'.$label.'
                </button>
            ';
        }
    }
    
    public function modifyButton($value){
    	return $this->genericButton($value, 'edit', 'Modifier', 'btn btn-primary redirect', 'fa fa-edit');
    }
    public function deleteButton($value){
        return $this->genericButton($value, 'delete', 'Supprimer', 'btn btn-danger', 'fa fa-trash-o');
    }
    public function addButton(){
        return $this->genericButton('', 'edit', 'Ajouter', 'btn btn-small btn-ribbon bt-primary redirect', 'fa fa-plus');
    }
    public function saveButton($value){
        return $this->genericButton($value, 'save', 'Enregistrer', 'btn btn-small btn-ribbon bt-primary', 'fa fa-save');
    }
    public function backButton(){
        return $this->genericButton('', 'catalog', 'Retour', 'btn btn-small btn-ribbon bt-primary redirect', 'fa fa-undo');
    }
    
    public function format(){
        $values = $this->getValues();
        $columns = $this->getColumns();
        foreach($values as &$record){
        	$newRecord = array();
        	foreach($columns as $column){
        		if(array_key_exists('button', $column)){
	        		if($column['button'] == 'modify'){
	        			$newRecord[] = $this->modifyButton($record['id']->__toString());
	        		}
	        		else if($column['button'] == 'delete'){
	        			$newRecord[] = $this->deleteButton($record['id']->__toString());
	        		}
        		}
        		else{
        			if(array_key_exists('callback', $column)){
        		        $newRecord[] = $this->callback[$column['callback']]($record[$column['name']]);
        			}
        			else{
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
                'form' => $form->createView(),
                'title' => $this->getEntity(),
                'ribbon' => $this->saveButton($id).$this->backButton()
            
            )
        );
    }
    public function catalogEntity(Request $request)
    {
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
                    'title' => $this->getEntity(),
                    'ribbon' => $this->addButton()
                )
            );
        }
    }
}
