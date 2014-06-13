<?php

namespace PHPOrchestra\CMSBundle\Model;

/**
 * Model\PHPOrchestraCMSBundle\Content bundle document.
 */
abstract class Content extends \Model\PHPOrchestraCMSBundle\Base\Content
{
    const STATUS_UNPUBLISHED = 'unpublished';
    const STATUS_PUBLISHED = 'published';
    const STATUS_DRAFT = 'draft';
    
    /**
     * Initializes the document defaults.
     */
    public function initializeDefaults()
    {
        if ($this->getVersion() == '') {
            $this->setVersion(1);
        }
        if ($this->getStatus() == '') {
            $this->setStatus(self::STATUS_DRAFT);
        }
        if ($this->isDeleted() == '') {
            $this->setDeleted(false);
        }
    }
    
    public function isDeleted()
    {
        return $this->getDeleted();
    }
    
    /**
     * Mark the document as deleted
     */
    public function markAsDeleted()
    {
        $this->setDeleted(true);
        return $this->save();
    }
    
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
    
    /**
     * Generate a draft version of the ContentType
     */
    public function generateDraft()
    {
        $this->setVersion(1 + $this->getVersion());
        $this->setStatus(self::STATUS_DRAFT);
        $this->setDeleted(false);
        $this->setId(null);
        $this->setIsNew(true);
        $this->save();
    }
    
    /**
     * Alias to addAttributes as used by symfony standard forms
     * 
     * @param document | document[] $documents
     */
    public function setAttributes($documents)
    {
        $this->addAttributes($documents);
        
        return $this;
    }
    
}
