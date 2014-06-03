<?php

/*
 * Business & Decision - Commercial License
 *
 * Copyright 2014 Business & Decision.
 *
 * All rights reserved. You CANNOT use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell this Software or any parts of this
 * Software, without the written authorization of Business & Decision.
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * See LICENSE.txt file for the full LICENSE text.
 */

namespace PHPOrchestra\BlockBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * Search Controller
 * 
 * @author Benjamin Fouché <benjamin.fouche@businessdecision.com>
 */
class SearchController extends Controller
{

	
	/**
	 * Display search field
	 */
	public function showAction($_value, $_name, $_class, $_nodeId)
	{
		// Search form
		$defaultData = null;
		$form = $this->createFormBuilder($defaultData)
		->setAction($this->generateUrl('php_orchestra_cms_node', array('nodeId' => $_nodeId)))
		->add(
				'Search',
				'text'
		)->getForm();
		
		return $this->render(
		    'PHPOrchestraBlockBundle:Search:show.html.twig',
			array(
				'form' => $form->createView(),
				'value' => $_value,
				'name' => $_name,
				'class' => $_class,
				'nodeId' => $_nodeId, 
			)
		);
	}


	/**
	 * Render the dialog form
	 *
	 * @param string $prefix
	 */
	public function formAction($prefix)
	{
		$form = $this->get('form.factory')
		->createNamedBuilder($prefix, 'form', null)
		->add(
			'value',
			'text'
		)
		->add(
			'name',
			'text'
		)
		->add(
			'class',
			'text'
		)
		->add(
			'nodeId',
			'text'
		)->getForm();
		

		return $this->render(
				'PHPOrchestraBlockBundle:Search:form.html.twig',
				array('form' => $form->createView())
		);
	}


	/**
	 * Render the search's result block
	 * 
	 * @param string $_nodeId node identifiant
	 * @param array $_page_parameters additional parameters extracted from url
	 * 
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function researchAction($_nodeId, $_page_parameters = array())
	{
		if (isset($_page_parameters['post']['form'])) {
			if (is_array($_page_parameters['post']['form'])) {
				$form = $_page_parameters['post']['form'];
				if (isset($form['Search'])) {
					$data = $form['Search'];
					
					//indexation
					$repositoryNode = $this->get('mandango')->getRepository('Model\PHPOrchestraCMSBundle\Node');
					$nodes = $repositoryNode->getAllNodes();
					$repositoryContent = $this->get('mandango')->getRepository('Model\PHPOrchestraCMSBundle\Content');
					$contents = $repositoryContent->getAllContents();
					$resultNode = $this->get('phporchestra_cms.indexsolr')->index($nodes);
					$resultContent = $this->get('phporchestra_cms.indexsolr')->index($contents);
					
					$resultset = $this->callResearch($data);
					return $this->render(
					    "PHPOrchestraBlockBundle:Search:search.html.twig",
	                    array(
	                    	'data' => $data,
						    'resultset' => $resultset,
	                    	'nodeId' => $_nodeId,
	                    )
				    );
					
				}
			}
		}
		if (isset($_page_parameters['query'])) {
			if (is_array($_page_parameters['query'])) {
				$form = $_page_parameters['query'];
				if (isset($form['Search'])) {
					$data = $form['Search'];
					
					$resultset = $this->callResearch($data);
					
					return $this->render(
					    "PHPOrchestraBlockBundle:Search:search.html.twig",
					    array(
					    	'data' => $data,
						    'resultset' => $resultset,
							'nodeId' => $_nodeId,
							)
					);
				}
			}
		}
		return new Response('Erreur ');
	}


	/**
	 * Search in solr
	 * 
	 * @param string $data 
	 * @return multitype:NULL |unknown
	 */
	public function callResearch($data)
	{
		$client = $this->get('solarium.client');
		$query  = $client->createSelect();
		
		// Research
		$search = $this->get('phporchestra_cms.searchsolr');
		$search->search($data, $query);
			
		// Spell check setting
		$search->spellCheck($query, $data);
			
		// Result
		$resultset = $client->select($query);
		
		//var_dump($resultset->getSpellcheck());
		if ($resultset->getNumFound() < 1) {
			$result = array();
			$spellcheck = $resultset->getSpellcheck();
			if (isset($spellcheck)) {
				$suggestions = $resultset->getSpellcheck()->getSuggestions();
				if (isset($suggestions)) {
					foreach ($suggestions as $suggest) {
						$search->search($suggest->getword(), $query);
						$result[] = $client->select($query);
					}
				}
			}
			return $result;
		} else {
			return $resultset;
		}
	}
}