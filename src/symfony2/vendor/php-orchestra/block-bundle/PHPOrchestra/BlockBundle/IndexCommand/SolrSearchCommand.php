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

namespace PHPOrchestra\BlockBundle\IndexCommand;

use Symfony\Component\DependencyInjection\Container;
use Solarium;

/**
 * Solr Search Command services
 *
 * @author Benjamin Fouché <benjamin.fouche@businessdecision.com>
 */
class SolrSearchCommand
{

    /**
     * @var Symfony\Component\DependencyInjection\Container
     */
    protected $container;
    
    
    /**
     * Instantiate the container
     *
     * @param Symfony\Component\DependencyInjection\Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }


    /**
     * This allows you to search in solr
     * 
     * @param string $data search words
     * @param Solarium\QueryType\Select\Query\Query $query
     * 
     * @return Solarium\QueryType\Select\Query\Query
     */
    public function search($data, $query, $options = array())
    {
        $query->setQuery($data);
        if (isset($options)) {
            if (isset($options['start']) && isset($options['rows'])) {
                $query->setStart($options['start'])->setRows($options['rows']);
            }
            if (isset($options['fields'])) {
                $query->Fields($options['fields']);
            }
            if (isset($options['sort']) && isset($options['sortMode'])) {
                $sortMode = 'Solarium\QueryType\Select\Query\Query::'.$options['sortMode'];
                $query->addSort($options['sort'], $sortMode);
            }
        }
        return $query;
    }


    /**
     * 
     * @param Solarium\QueryType\Select\Query\Query $query
     * @param string|array $fields fields name
     * @param string|array $boost boosts number
     * @param string $mm Minimum Match
     * 
     * @return Solarium\QueryType\Select\Query\Query
     */
    public function disMax($query, $fields, $boost, $mm = null)
    {
        $dismax = $query->getDisMax();
        $dismax->setQueryParser('edismax');
        
        if (is_array($fields) && is_array($boost)) {
            $stringField = '';
            $i = 0;
            foreach ($fields as $field) {
                $stringField .= $field.'^'.$boost[$i].' ';
                $i++;
            }
            $dismax->setQueryFields($stringField);
        } else {
            $dismax->setQueryFields($fields.'^'.$boost);
        }
        
        // Minimum Match
        if (isset($mm)) {
            $dismax->setMinimumMatch($mm);
        }

        return $query;
    }


    /**
     * This allows you to search with approach spell
     * 
     * @param Solarium\QueryType\Select\Query\Query $query
     * @param string $data search words
     * @param int $number number of spellcheck response
     * 
     * @return Solarium\QueryType\Select\Query\Query
     */
    public function spellCheck($query, $data, $number = null)
    {
        //Spell check setting
        $spellcheck = $query->getSpellcheck();
        $spellcheck->setQuery($data);

        if (isset($number)) {
            $spellcheck->setCount($number);
        }
        //$spellcheck->setCollate(true);
        $spellcheck->setExtendedResults(true);
        $spellcheck->setCollateExtendedResults(true);

        return $query;
    }


    /**
     * This allows you to specify a field which should be treated as a facet
     * 
     * @param Solarium\QueryType\Select\Query\Component\FacetSet $facetSet
     * @param string $name facet's name
     * @param string $field field where we use facet
     * @param array $options array of facet options
     */
    public function facetField($facetSet, $name, $field, $options = array())
    {
        $facet = $facetSet->createFacetField($name)->setField($field);
        if (isset($options)) {
            if (isset($options['sort'])) {
                $facet->setSort($options['sort']);
            }
            if (isset($options['limit'])) {
                $facet->setLimit($options['limit']);
            }
            if (isset($options['prefix'])) {
                $facet->setPrefix($options['prefix']);
            }
            if (isset($options['offset'])) {
                $facet->setOffset($options['offset']);
            }
            if (isset($options['minCount'])) {
                $facet->setMinCount($options['minCount']);
            }
            if (isset($options['missing'])) {
                $facet->setMissing($options['missing']);
            }
        }
    }


    /**
     * This allows you to specify an arbitrary query to generate a facet count.
     * 
     * @param Solarium\QueryType\Select\Query\Component\FacetSet $facetSet
     * @param string $field
     * @param string $query
     * 
     */
    public function facetQuery($facetSet, $field, $query)
    {
        $facet = $facetSet->createFacetQuery($field)->setQuery($query);
    }


    /**
     * This allows you to specify several arbitrary query to generate a facet count.
     * 
     * @param Solarium\QueryType\Select\Query\Component\FacetSet $facetSet 
     * @param string $field name of field
     * @param array $queries several query 
     */
    public function facetmultiQuery($facetSet, $field, $queries)
    {
        $facet = $facetSet->createFacetMultiQuery($field);
        
        if (is_array($queries)) {
            foreach ($queries as $name => $query) {
                $facet->createQuery($name, $query);
            }
        }
    }


    /**
     * This alloaws you to specify range to generate a facet
     * 
     * @param Solarium\QueryType\Select\Query\Component\FacetSet $facetSet
     * @param string $name name of this facet
     * @param string $field name of the field for the facet
     * @param int $start starting number
     * @param int $gap gap for the facet
     * @param int $end ending number
     */
    public function facetRange($facetSet, $name, $field, $start, $gap, $end)
    {
        $facet = $facetSet->createFacetRange($name);
        $facet->setField($field);
        $facet->setStart($start);
        $facet->setGap($gap);
        $facet->setEnd($end);
    }


    /**
     * This allows you to create a filter
     * 
     * @param Solarium\QueryType\Select\Query\Query $query 
     * @param string $name name of filter
     * @param string $filter the filter query
     * 
     * @return Solarium\QueryType\Select\Query\Query
     */
    public function filter($query, $name, $filter)
    {
        $query->createFilterQuery($name)->setQuery($filter);
        
        return $query;
    }
}
