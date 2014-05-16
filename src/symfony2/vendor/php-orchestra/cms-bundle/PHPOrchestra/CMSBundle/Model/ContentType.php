<?php

namespace PHPOrchestra\CMSBundle\Model;

/**
 * Model\PHPOrchestraCMSBundle\ContentType bundle document.
 */
abstract class ContentType extends \Model\PHPOrchestraCMSBundle\Base\ContentType
{
    public function toArray($withReferenceFields = false)
    {
        $document = parent::toArray($withReferenceFields);
        
        $fields = $this->getFields();
        
        $fieldsToArray = array();
        
        foreach ($fields as $field) {
            $fieldsToArray[] = $field->toArray();
        }
        
        $document['fields'] = $fieldsToArray;
        
        return $document;
    }
}
