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
use Symfony\Component\HttpFoundation\JsonResponse;

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
                'url' => 'php_orchestra_autocomplete',
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


    public function autocompleteAction()
    {
        $request = $this->container->get('request');

        $terms = $request->query->get('term');

        $client = $this->get('solarium.client');
        
        $query = $client->createSuggester();
        $query->setHandler('suggest');
        
        $query->setQuery($terms);
        
        $query->setCollate(true);
        
        $resultset = $client->suggester($query);
        $result = array();
        foreach ($resultset->getResults() as $suggest) {
            $result[] = $suggest;
        }
        $result2 = "";
        if (isset($result)) {
            foreach ($result as $suggest) {
                $result2 = $suggest->getSuggestions();
            }
        }
        
        return new JsonResponse($result2);
        //return new Response(implode("", $result2));
    }


    /**
     * Render the search's result block
     * 
     * @param string $_nodeId node identifiant
     * @param array $_page_parameters additional parameters extracted from url
     * 
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function researchAction($_nodeId, $_page = null, $_page_parameters = array())
    {
        $nbdoc = 5;
        $facetField = array('name' => 'parent', 'field' => 'parentId', 'options' => array());
        $facetQuery = array('field' => 'root', 'query' => 'id: root');
        $facetMulti = array(
            'field' => 'identifiant',
            'queries' => array('root' => 'id: root', 'full' => 'id: fixture_full')
        );
        $facetRange = array('name' => 'identifiant', 'field' => 'id', 'start' => '1', 'gap' => '1', 'end' => '3');
        $facet = array('facetField' => $facetField);
        if (!isset($_page)) {
            $_page = 1;
        }
        if (isset($_page_parameters['post']['form'])) {
            if (is_array($_page_parameters['post']['form'])) {
                $form = $_page_parameters['post']['form'];
                if (isset($form['Search'])) {
                    $data = $form['Search'];
                    
                    $optionsearch = array('start' => ($_page * $nbdoc) - $nbdoc, 'rows' => $_page * $nbdoc);
                    
                    $resultSet = $this->callResearch($data, $optionsearch, $facet);
                    //var_dump($result->getComponents());
                    
                    return $this->callTemplate($data, $resultSet, $_nodeId, $_page, $nbdoc, $facet);
                    
                }
            }
        }
        if (isset($_page_parameters['query'])) {
            if (is_array($_page_parameters['query'])) {
                $form = $_page_parameters['query'];
                if (isset($form['Search'])) {
                    $data = $form['Search'];
                    
                    if (isset($form['page'])) {
                        $_page = $form['page'];
                    }
                    $optionsearch = array('start' => ($_page * $nbdoc) - $nbdoc, 'rows' => $_page * $nbdoc);
                    $resultSet = $this->callResearch($data, $optionsearch, $facet);
                    
                    return $this->callTemplate($data, $resultSet, $_nodeId, $_page, $nbdoc, $facet);

                } else {
                    if (isset($form['data']) && isset($form['filter']) && isset($form['facetname'])) {
                        
                        $resultSet = $this->callFilter($form['data'], $form['filter'], $form['facetname']);
                        
                        return $this->callTemplate($form['data'], $resultSet, $_nodeId, $_page, $nbdoc, $facet);
                    }
                }
            }
        }
        return new Response('Erreur ');
    }


    /**
     * Search in solr
     * 
     * @param string $data searching word
     * @param array $optionSearch array of option to the search
     * @param array $facets array of option to the facets 
     * 
     * @return Solarium\QueryType\Select\Result\Result
     */
    public function callResearch($data, $optionSearch = array(), $facets = array())
    {
        $client = $this->get('solarium.client');
        $query  = $client->createSelect();
        
        // Research
        $search = $this->get('phporchestra_cms.searchsolr');
        $search->search($data, $query, $optionSearch);
        
        // Spell check setting
        $search->spellCheck($query, $data, 6);
        
        //faceting
        if (isset($facets)) {
            $this->callFacet($query, $search, $facets);
        }
        return $this->result($client, $query, $search);
    }


    /**
     * Create a filter query
     * 
     * @param string $data search word
     * @param string $filter query filter
     * @param string $facetName facet name
     */
    public function callFilter($data, $filter, $facetName)
    {
        $client = $this->get('solarium.client');
        $query  = $client->createSelect();
        
        $query->setQuery($data);
        $query->createFilterQuery($facetName)->setQuery($filter);
        
        return $client->select($query);
    }


    /**
     * Return result of the query
     * 
     * @param Solarium\Client $client
     * @param Solarium\QueryType\Select\Query\Query $query
     * @param PHPOrchestra\BlockBundle\IndexCommand\SolrSearchCommand $search
     * 
     * @return multitype:NULL array |Solarium\QueryType\Select\Result\Result
     */
    public function result($client, $query, $search)
    {
        // Result
        $resultset = $client->select($query);
        //var_dump($resultset->getSpellcheck()->getSuggestions());
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


    /**
     * Call facet services
     * 
     * @param Solarium\QueryType\Select\Query\Query $query
     * @param PHPOrchestra\BlockBundle\IndexCommand\SolrSearchCommand $search search services
     * @param array $facets 
     */
    public function callFacet($query, $search, $facets)
    {
        $facetSet = $query->getFacetSet();
        
        if (isset($facets['facetField'])) {
            if (isset($facets['facetField']['name']) && isset($facets['facetField']['field'])
             && isset($facets['facetField']['options'])) {
                $search->facetField(
                    $facetSet,
                    $facets['facetField']['name'],
                    $facets['facetField']['field'],
                    $facets['facetField']['options']
                );
            }
        }
        if (isset($facets['facetQuery'])) {
            if (isset($facets['facetQuery']['field']) && isset($facets['facetQuery']['query'])) {
                $search->facetQuery(
                    $facetSet,
                    $facets['facetQuery']['field'],
                    $facets['facetQuery']['query']
                );
            }
        }
        if (isset($facets['multiQuery'])) {
            if (isset($facets['multiQuery']['field']) && isset($facets['multiQuery']['queries'])) {
                $search->facetmultiQUery(
                    $facetSet,
                    $facets['multiQuery']['field'],
                    $facets['multiQuery']['queries']
                );
            }
        }
        if (isset($facets['facetRange'])) {
            if (isset($facets['facetRange']['name']) && isset($facets['field'])
             && isset($facets['facetRange']['start']) && isset($facets['facetRange']['gap'])
             && isset($facets['facetRange']['end'])) {
                $search->facetRange(
                    $facetSet,
                    $facets['facetRange']['name'],
                    $facets['facetRange']['field'],
                    $facets['facetRange']['start'],
                    $facets['facetRange']['gap'],
                    $facets['facetRange']['end']
                );
            }
        }
    }


    /**
     * Call search template
     * 
     * @param string $data search word
     * @param unknown $resultSet 
     * @param string $nodeId identifiant of node
     * @param int $page number of page
     * @param int $nbdoc number of documents per page selected by the user
     * @param array $facets array if they have facets
     * 
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function callTemplate($data, $resultSet, $nodeId, $page, $nbdoc, $facets = array())
    {
        if (isset($facets)) {
            return $this->render(
                "PHPOrchestraBlockBundle:Search:search.html.twig",
                array(
                    'data' => $data,
                    'resultset' => $resultSet,
                    'nodeId' => $nodeId,
                    'page' => $page,
                    'nbdocs' => $nbdoc,
                    'facetsArray' => $facets
                )
            );
        } else {
            return $this->render(
                "PHPOrchestraBlockBundle:Search:search.html.twig",
                array(
                    'data' => $data,
                    'resultset' => $resultset,
                    'nodeId' => $nodeId,
                    'page' => $page,
                    'nbdocs' => $nbdoc,
                )
            );
        }
    }
}
