<?php

namespace PHPOrchestra\CMSBundle\Test\Mock;

/**
 * Description of MandangoDocumentRepository
 *
 * @author Nicolas BOUQUET <nicolas.bouquet@businessdecision.com>
 */
class MandangoDocumentRepository extends \Mandango\Repository
{
    /**
     * Setter to dynamically change the document class
     * 
     * @param string $class Document class name
     */
    public function setDocumentClass($class)
    {
        $this->documentClass = $class;
    }
    
    /**
     * Create query with an array of filters
     * 
     * @param array $criteria Filters
     * @return \PHPOrchestra\CMSBundle\Test\Mock\MandangoDocumentQuery
     */
    public function createQuery(array $criteria = array())
    {
        $query = new MandangoDocumentQuery($this);
        $query->criteria($criteria);

        return $query;
    }

    /**
     * Converts an object Id to Mongo Id
     * (nothing to do, we don't use a real mongo db here)
     * 
     * @param string $identifier
     * @return string
     */
    public function idToMongo($identifier)
    {
        return $identifier;
    }
    
    /**
     * Creates a MongoDB Collection mock
     * 
     * @return MongoCollection
     */
    public function getCollection()
    {
        $generator = new \PHPUnit_Framework_MockObject_Generator;
        
        /**
         * @var \PHPUnit_Framework_MockObject_MockObject
         */
        $collection = $generator->getMock(
            '\\MongoCollection',
            array(),
            array(),
            '',
            false
        );
        
        $collection->expects(new \PHPUnit_Framework_MockObject_Matcher_AnyInvokedCount)
            ->method('aggregate')
            ->willReturnCallback(array($this, 'aggregate'));
        
        return $collection;
    }
    
    public function aggregate()
    {
        $result = $this->getMandango()->getDB();
        return array(
            'result' => $result[$this->documentClass],
            'ok' => 1
        );
    }
}
