<?php

namespace PHPOrchestra\CMSBundle\Test\Mock;

/**
 * Description of MandangoDocumentQuery
 *
 * @author Nicolas BOUQUET <nicolas.bouquet@businessdecision.com>
 */
class MandangoDocumentQuery extends \Mandango\Query
{
    public function __construct(\Mandango\Repository $repository)
    {
        $this->repository = $repository;
    }
    
    public function createCursor()
    {
        $class = $this->repository->getDocumentClass();
        $data  = $this->repository->getMandango()->getDB();
        
        $count = 0;
        $documents = array();
        
        foreach ($data[$class] as $id => $document) {
            $check = true;
            foreach ($this->getCriteria() as $attribute => $value) {
                $field = $this->attributeNameToFieldName($attribute);
                
                if (!isset($document[$field])
                || $document[$field] !== $value) {
                    $check = false;
                }
            }
            
            if ($check) {
                $documents[$id] = $document;
                $count++;
            }
            
            if ($count >= $this->getLimit()) {
                break;
            }
        }

        return $documents;
    }
    
    public function all()
    {
        $repository    = $this->repository;
        $mandango      = $repository->getMandango();
        
        $documents = array();
        foreach ($this->createCursor() as $id => $data) {
            $document = new MandangoDocument($mandango);
            $document->setDocumentData($data);
            $documents[$id] = $document;
        }
        
        return $documents;
    }
    
    public function attributeNameToFieldName($attributeName)
    {
        // CamelCase to snake_case
        return strtolower(
            preg_replace(
                '/([a-z])([A-Z])/',
                '$1_$2',
                $attributeName
            )
        );
    }
}
