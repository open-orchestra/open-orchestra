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

abstract class ViewController extends Controller
{
	
	private $entity = null;
	private $searchs = array();
    private $labels = array();
    private $values = array();
    private $route;
    
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
    
    public function setRoute($route){
        $this->route = $route;
    }
    
    public function getRoute(){
        return $this->route;
    }
    
    public function modifyButton($value){
    	return '
            <button data-contenttype="'.$this->generateUrl($this->getRoute().'_edit', array('id' => $value)).'" value="Modifier" class="btn btn-primary editContentType">
               <i class="fa fa-edit"></i>
               Modifier
            </button>
        ';
    }
	
    public function deleteButton($value){
        return '
            <button data-contenttype="'.$this->generateUrl($this->getRoute().'_delete', array('id' => $value)).'" value="Supprimer" class="btn btn-danger">
                <i class="fa fa-trash-o"></i>
                Supprimer
            </button>
        ';
    }
    
    /**
     * @Route("/edit/{id}")
     */
    public function editAction($id){}
    /**
     * @Route("/delete/{id}")
     */
    public function deleteAction($id){}
    /**
     * @Route("/list")
     */
    public function listAction(Request $request)
    {
    	$this->setRoute(preg_replace('/^(.*)_list$/', '$1', $request->get('_route')));

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
                    'listUrl' => $request->get('_route'),
                    'deleteUrl' => $request->get('_route'),
                )
            );
        }
     }
}
