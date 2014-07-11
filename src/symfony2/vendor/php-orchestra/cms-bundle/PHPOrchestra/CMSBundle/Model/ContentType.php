<?php

namespace PHPOrchestra\CMSBundle\Model;

/**
 * Model\PHPOrchestraCMSBundle\ContentType bundle document.
 */
abstract class ContentType extends \Model\PHPOrchestraCMSBundle\Base\ContentType
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
     * (non-PHPdoc)
     * @see src/symfony2/src/Model/PHPOrchestraCMSBundle/Base/Model\PHPOrchestraCMSBundle\Base.ContentType::toArray()
     */
    public function toArray($withReferenceFields = false)
    {
        $document = parent::toArray($withReferenceFields);
        
        $document['fields'] =  json_decode($this->getFields());
        
        return $document;
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
     * Generate a draft version of the ContentType
     */
    public function generateDraft()
    {
        $this->setContentTypeId($this->getContentTypeId());
        $this->setName($this->getName());
        $this->setVersion(\time());
        $this->setStatus(self::STATUS_DRAFT);
        $this->setDeleted(false);
        $this->setFields($this->getfields());
        
        $this->setIsNew(true);
        $this->save();
    }
}
