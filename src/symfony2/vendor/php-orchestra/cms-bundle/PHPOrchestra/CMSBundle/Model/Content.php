<?php

namespace PHPOrchestra\CMSBundle\Model;

/**
 * Model\PHPOrchestraCMSBundle\Content bundle document.
 */
abstract class Content extends \Model\PHPOrchestraCMSBundle\Base\Content
{
    /**
     * (non-PHPdoc)
     * @see src/symfony2/src/Model/PHPOrchestraCMSBundle/Base/Model\PHPOrchestraCMSBundle\Base.Content::toArray()
     */
    public function toArray($withReferenceFields = false)
    {
        $document = parent::toArray($withReferenceFields);
        
        $attributes = $this->getAttributes();
        $attributesToArray = array();
        foreach ($attributes as $attribute) {
            $attributesToArray[] = $attribute->toArray();
        }
        $document['attributes'] = $attributesToArray;
        
        return $document;
    }
}
