<?php

/*
 * Business & Decision - Commercial License
 *
 * Copyright 2014 Business & Decision.
 *
 * All rights reserved. You CANNOT use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell this Software or any parts of this
 * Software, without the written authorization of Business & Decision.
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * See LICENSE.txt file for the full LICENSE text.
 */

namespace PHPOrchestra\ModelBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * Description of BaseNode
 *
 * @author Nicolas BOUQUET <nicolas.bouquet@businessdecision.com>
 */
abstract class BaseNode
{
    /**
     * @var string $id
     * @MongoDB\Id
     */
    protected $id;
    
    /**
     * @var int $nodeId
     * @MongoDB\Field(type="int")
     */
    protected $nodeId;
    
    /**
     * @var string $nodeType
     * @MongoDB\Field(type="string")
     */
    protected $nodeType;
    
    /**
     * @var int $siteId
     * @MongoDB\Field(type="int")
     */
    protected $siteId;
    
    /**
     * @var int $parentId
     * @MongoDB\Field(type="int")
     */
    protected $parentId;
    
    /**
     * @var string $path
     * @MongoDB\Field(type="string")
     */
    protected $path;
    
    /**
     * @var string $alias
     * @MongoDB\Field(type="string")
     */
    protected $alias;
    
    /**
     * @var string $name
     * @MongoDB\Field(type="string")
     */
    protected $name;
    
    /**
     * @var int $version
     * @MongoDB\Field(type="int")
     */
    protected $version;
    
    /**
     * @var string $language
     * @MongoDB\Field(type="string")
     */
    protected $language;
    
    /**
     * @var string $status
     * @MongoDB\Field(type="string")
     */
    protected $status;
    
    /**
     * @var boolean
     * @MongoDB\Field(type="boolean")
     */
    protected $deleted;
    
    /**
     * @var string
     * @MongoDB\Field(type="string")
     */
    protected $templateId;
    
    /**
     * @var string
     * @MongoDB\Field(type="string")
     */
    protected $theme;
    
    /**
     * @var PHPOrchestraModel\MongoBundle\Document\Area
     * @MongoDB\EmbedOne(targetDocument="PHPOrchestraModel\MongoBundle\Document\Area")
     */
    protected $areas;
    
    /**
     * @var PHPOrchestraModel\MongoBundle\Document\Block
     * @MongoDB\EmbedMany(targetDocument="PHPOrchestraModel\MongoBundle\Document\Block")
     */
    protected $blocks = array();

    public function __construct()
    {
        $this->blocks = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nodeId
     *
     * @param int $nodeId
     * @return self
     */
    public function setNodeId($nodeId)
    {
        $this->nodeId = $nodeId;
        return $this;
    }

    /**
     * Get nodeId
     *
     * @return int $nodeId
     */
    public function getNodeId()
    {
        return $this->nodeId;
    }

    /**
     * Set nodeType
     *
     * @param string $nodeType
     * @return self
     */
    public function setNodeType($nodeType)
    {
        $this->nodeType = $nodeType;
        return $this;
    }

    /**
     * Get nodeType
     *
     * @return string $nodeType
     */
    public function getNodeType()
    {
        return $this->nodeType;
    }

    /**
     * Set siteId
     *
     * @param int $siteId
     * @return self
     */
    public function setSiteId($siteId)
    {
        $this->siteId = $siteId;
        return $this;
    }

    /**
     * Get siteId
     *
     * @return int $siteId
     */
    public function getSiteId()
    {
        return $this->siteId;
    }

    /**
     * Set parentId
     *
     * @param int $parentId
     * @return self
     */
    public function setParentId($parentId)
    {
        $this->parentId = $parentId;
        return $this;
    }

    /**
     * Get parentId
     *
     * @return int $parentId
     */
    public function getParentId()
    {
        return $this->parentId;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return self
     */
    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }

    /**
     * Get path
     *
     * @return string $path
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set alias
     *
     * @param string $alias
     * @return self
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;
        return $this;
    }

    /**
     * Get alias
     *
     * @return string $alias
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set version
     *
     * @param int $version
     * @return self
     */
    public function setVersion($version)
    {
        $this->version = $version;
        return $this;
    }

    /**
     * Get version
     *
     * @return int $version
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Set language
     *
     * @param string $language
     * @return self
     */
    public function setLanguage($language)
    {
        $this->language = $language;
        return $this;
    }

    /**
     * Get language
     *
     * @return string $language
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return self
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * Get status
     *
     * @return string $status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set deleted
     *
     * @param boolean $deleted
     * @return self
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;
        return $this;
    }

    /**
     * Get deleted
     *
     * @return boolean $deleted
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * Set templateId
     *
     * @param string $templateId
     * @return self
     */
    public function setTemplateId($templateId)
    {
        $this->templateId = $templateId;
        return $this;
    }

    /**
     * Get templateId
     *
     * @return string $templateId
     */
    public function getTemplateId()
    {
        return $this->templateId;
    }

    /**
     * Set theme
     *
     * @param string $theme
     * @return self
     */
    public function setTheme($theme)
    {
        $this->theme = $theme;
        return $this;
    }

    /**
     * Get theme
     *
     * @return string $theme
     */
    public function getTheme()
    {
        return $this->theme;
    }

    /**
     * Set areas
     *
     * @param PHPOrchestraModel\MongoBundle\Document\Area $areas
     * @return self
     */
    public function setAreas(\PHPOrchestraModel\MongoBundle\Document\Area $areas)
    {
        $this->areas = $areas;
        return $this;
    }

    /**
     * Get areas
     *
     * @return PHPOrchestraModel\MongoBundle\Document\Area $areas
     */
    public function getAreas()
    {
        return $this->areas;
    }

    /**
     * Add block
     *
     * @param PHPOrchestraModel\MongoBundle\Document\Block $block
     */
    public function addBlock(\PHPOrchestraModel\MongoBundle\Document\Block $block)
    {
        $this->blocks[] = $block;
    }

    /**
     * Remove block
     *
     * @param PHPOrchestraModel\MongoBundle\Document\Block $block
     */
    public function removeBlock(\PHPOrchestraModel\MongoBundle\Document\Block $block)
    {
        $this->blocks->removeElement($block);
    }

    /**
     * Get blocks
     *
     * @return Doctrine\Common\Collections\Collection $blocks
     */
    public function getBlocks()
    {
        return $this->blocks;
    }
}
