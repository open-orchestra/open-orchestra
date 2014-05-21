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

abstract class ViewController extends Controller
{
	
	private $entity = null;
	private $searchs = array();
    private $labels = array();
    private $values = array();
    
    abstract public function format();
	
	public function setEntity($entity){
		$this->entity = $entity;
	}
	
    public function getEntity(){
        return $this->entity;
    }

    public function setLabels($labels)
    {
        $this->labels = $labels;
    }
    
    public function getLabels()
    {
        return $this->labels;
    }

    public function setSearchs($searchs)
    {
        $this->searchs = $searchs;
    }
    
    public function getSearchs()
    {
        return $this->searchs;
    }
    
    public function setValues($values){
        $this->values = $values;
    }
    
    public function getValues(){
        return $this->values;
    }
    
    public function modifyButton($value){
    	return '
            <button onclick="document.location.href=\'\'" value="Modifier" class="btn btn-primary">
               <i class="fa fa-edit"></i>
               Modifier
            </button>
        ';
    }
	
    public function deleteButton($value){
        return '
            <button onclick="document.location.href=\'\'" value="Supprimer" class="btn btn-danger">
                <i class="fa fa-trash-o"></i>
                Supprimer
            </button>
        ';
    }
    
    public function listActionEntity(Request $request)
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
            return $this->render('PHPOrchestraCMSBundle:BackOffice:viewLayout.html.twig',
                array(
                    'labels' => $this->getLabels(),
                    'searchs' => $this->getSearchs(),
                )
            );
            return $this->forward('PHPOrchestraCMSBundle:View:list', $params);
        }
     }
}
