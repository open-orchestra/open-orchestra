<?php

namespace PHPOrchestra\CMSBundle\Model;

/**
 * Model\PHPOrchestraCMSBundle\Node bundle document.
 */
abstract class Node extends \Model\PHPOrchestraCMSBundle\Base\Node
{
    const STATUS_DRAFT = 'draft';
    const STATUS_PENDING = 'pending';
    const STATUS_PUBLISHED = 'published';
    
    const TYPE_DEFAULT = 'page';
    
    const ROOT_NODE_ID = 'root';
    
    /**
     * Initializes the document defaults.
     */
    public function initializeDefaults()
    {
        if ($this->getNodeId() == '') {
            $this->setNodeId(uniqid('', true));
        }
        if ($this->getNodeType() == '') {
            $this->setNodeType(self::TYPE_DEFAULT);
        }
        if ($this->getVersion() == '') {
            $this->setVersion(1);
        }
        if ($this->getStatus() == '') {
            $this->setStatus(self::STATUS_DRAFT);
        }
        if ($this->getLanguage() == '') {
            $this->setLanguage('fr');
        }
        if ($this->getParentId() == '') {
            $this->setParentId(self::ROOT_NODE_ID);
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
    
    public function markAsDeleted()
    {
        $this->setDeleted('true');
        return $this->save();
    }
}
