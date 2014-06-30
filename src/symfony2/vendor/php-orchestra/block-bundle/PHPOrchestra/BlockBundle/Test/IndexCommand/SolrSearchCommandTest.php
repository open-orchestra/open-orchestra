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

namespace PHPOrchestra\BlockBundle\Test\IndexCommand;
    
use PHPOrchestra\BlockBundle\IndexCommand\SolrSearchCommand;
use JMS\Serializer\Tests\Fixtures\Publisher;

/**
 * Unit test of SolrSearchCommand
 *
 * @author Benjamin Fouché <benjamin.fouche@businessdecision.com>
 *
 */
class SolrSearchCommandTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var Symfony\Component\DependencyInjection\Container
     */
    protected $container = null;

    /**
     *
     * @var PHPOrchestra\BlockBundle\IndexCommand\SolrSearchCommand
     */
    protected $solrSearchCommand = null;
    
    /**
     * 
     * @var Solarium\QueryType\Select\Query\Query
     */
    protected $query = null;
    
    
    /**
     * Set up unit test
     * 
     * @see PHPUnit_Framework_TestCase::setUp()
     */
    public function setUp()
    {
        $this->container = $this->getMock('\\Symfony\\Component\\DependencyInjection\\Container', array('get'));
        $this->query = $this->getMock('\\Solarium\\QueryType\\Select\\Query\\Query');
        $this->solrSearchCommand = new SolrSearchCommand($this->container);
    }


    /**
     * Test search()
     */
    public function testSearch()
    {
        $result = $this->solrSearchCommand->search('Bienvenue', $this->query);
        
        $this->assertEquals($this->query, $result);
    }


    /**
     * Test disMax()
     */
    public function testDisMax()
    {
        $dismax = $this->getMock('\\Solarium\\QueryType\\Select\\Query\\Component\\DisMax');
        $this->query->expects($this->once())->method('getDisMax')->will($this->returnValue($dismax));
        
        $result = $this->solrSearchCommand->disMax($this->query, 'title', '2');
        
        $this->assertEquals($this->query, $result);
    }


    /**
     * Test spellCheck()
     */
    public function testSpellCheck()
    {
        $spellcheck = $this->getMock('\\Solarium\\QueryType\\Select\\Query\\Component\\Spellcheck');
        $this->query->expects($this->once())->method('getSpellcheck')->will($this->returnValue($spellcheck));
        
        $result = $this->solrSearchCommand->spellCheck($this->query, 'title');
        
        $this->assertEquals($this->query, $result);
    }

    
    /**
     * Test facetField()
     */
    public function testFacetField()
    {
        $facetSet = $this->getMock('\\Solarium\\QueryType\\Select\\Query\\Component\\FacetSet');
        $facetField = $this->getMock('\\Solarium\\QueryType\\Select\\Query\\Component\\Facet\\Field');
        $facetSet->expects($this->once())->method('createFacetField')->will($this->returnValue($facetField));
        
        $result = $this->solrSearchCommand->facetField($facetSet, 'parent', 'parentId');
        
        $this->assertEquals('', $result);
    }

    
    /**
     * Test facetQuery()
     */
    public function testFacetQuery()
    {
        $facetSet = $this->getMock('\\Solarium\\QueryType\\Select\\Query\\Component\\FacetSet');
        $facetQuery = $this->getMock('\\Solarium\\QueryType\\Select\\Query\\Component\\Facet\\Query');
        $facetSet->expects($this->once())->method('createFacetQuery')->will($this->returnValue($facetQuery));
        
        $result = $this->solrSearchCommand->facetQuery($facetSet, 'root', 'id:root');
        
        $this->assertEquals('', $result);
    }
    
    
    /**
     * Test facetmultiQuery()
     */
    public function testFacetmultiQuery()
    {
        $facetSet = $this->getMock('\\Solarium\\QueryType\\Select\\Query\\Component\\FacetSet');
        $facetMulti = $this->getMock('\\Solarium\\QueryType\\Select\\Query\\Component\\Facet\\MultiQuery');
        $facetSet->expects($this->once())->method('createFacetMultiQuery')->will($this->returnValue($facetMulti));
        
        $queries = array('root' => 'id: root', 'full' => 'id: fixture_full');
        $result = $this->solrSearchCommand->facetmultiQuery($facetSet, 'identifiant', $queries);
        
        $this->assertEquals('', $result);
    }

    
    /**
     * Test facetRange()
     */
    public function testFacetRange()
    {
        $facetSet = $this->getMock('\\Solarium\\QueryType\\Select\\Query\\Component\\FacetSet');
        $facetRange = $this->getMock('\\Solarium\\QueryType\\Select\\Query\\Component\\Facet\\Range');
        $facetSet->expects($this->once())->method('createFacetRange')->will($this->returnValue($facetRange));
        
        $result = $this->solrSearchCommand->facetRange($facetSet, 'root', 'prix', 0, 1, 10);
        
        $this->assertEquals('', $result);
    }


    /**
     * Test filter()
     */
    public function testFilter()
    {
        $filter = $this->getMock('\\Solarium\\QueryType\\Select\\Query\\FilterQuery');
        $this->query->expects($this->once())->method('createFilterQUery')->will($this->returnValue($filter));
        
        $result = $this->solrSearchCommand->filter($this->query, 'parent', 'parentId:root');
        
        $this->assertEquals($this->query, $result);
    }
}
