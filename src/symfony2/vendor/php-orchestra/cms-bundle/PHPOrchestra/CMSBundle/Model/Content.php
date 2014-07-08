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
        if ($this->getLanguage() == '') {
            $this->setLanguage('fr');
        }
        if ($this->isDeleted() == '') {
            $this->setDeleted(false);
        }
        if ($this->getContentId() == '') {
            $this->setContentId(\time());
        }
    }
    
    /**
     * Alias to getDeleted
     */
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
     * Generate a draft version of the Content
     */
    public function generateDraft()
    {
        $this->setContentId($this->getContentId());
        $this->setContentType($this->getContentType());
        $this->setVersion(\time());
        $this->setLanguage($this->getLanguage());
        $this->setStatus(self::STATUS_DRAFT);
        $this->setShortName($this->getShortName());
        $this->setDeleted(false);
        $attributes = $this->getAttributes();
        foreach ($attributes as $attribute) {
            $this->addAttributes($attribute);
        }
        
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
    

    /**
     * Give content for the document
     *
     * @param Solarium\QueryType\Update\Query\Document\Document $doc
     * @param array $fields
     *
     * @return Solarium\QueryType\Update\Query\Document\Document
     */
    public function toSolrDocument($doc, $fields)
    {
        $doc->id = $this->getContentId();
        $doc->name = $this->getShortName();
        $doc->version = $this->getVersion();
        $doc->language = $this->getLanguage();
        $doc->type = $this->getContentType();
        $doc->status = $this->getStatus();
         
        foreach ($fields as $name => $value) {
            if (!empty($value)) {
                $doc->$name = implode("", $value);
            }
        }
    
        return $doc;
    }
}
