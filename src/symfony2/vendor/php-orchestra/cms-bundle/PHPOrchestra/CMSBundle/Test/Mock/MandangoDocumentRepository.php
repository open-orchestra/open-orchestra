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
     * @param string $id
     * @return string
     */
    public function idToMongo($id)
    {
        return $id;
    }
}
