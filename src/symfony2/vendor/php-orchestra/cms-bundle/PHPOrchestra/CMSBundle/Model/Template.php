<?php

namespace PHPOrchestra\CMSBundle\Model;

/**
 * Model\PHPOrchestraCMSBundle\Template bundle document.
 */
abstract class Template extends \Model\PHPOrchestraCMSBundle\Base\Template
{
    const STATUS_DRAFT = 'draft';
    const STATUS_PENDING = 'pending';
    const STATUS_PUBLISHED = 'published';
    
    /**
     * Initializes the document defaults.
     */
    public function initializeDefaults()
    {
        if ($this->getTemplateId() == '') {
            $this->setTemplateId(uniqid('', true));
        }
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
    
    /**
     * Alias to addBlocks as used by symfony standard forms
     * 
     * @param document | document[] $documents
     */
    public function setBlocks($documents)
    {
        $this->addBlocks($documents);
        
        return $this;
    }
    
    /**
     * Alias to getDeleted
     */
    public function isDeleted()
    {
        return $this->getDeleted();
    }
    
    /**
     * Flag all versions of the template templateId as deleted
     * 
     * @param $templateId
     */
    public function markAsDeleted()
    {
        $this->setDeleted('true');
        return $this->save();
    }
}
