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
 * Description of BaseArea
 *
 * @author Nicolas BOUQUET <nicolas.bouquet@businessdecision.com>
 * 
 * @MongoDB\EmbeddedDocument
 */
abstract class BaseArea
{
    /**
     * @var string $htmlId
     * @MongoDB\Field(type="string")
     */
    protected $htmlId = null;
    
    /**
     * @var string $boDirection
     * @MongoDB\Field(type="string")
     */
    protected $boDirection = null;
    
    /**
     * @var float $boPercent
     * @MongoDB\Field(type="float")
     */
    protected $boPercent = null;
    
    /**
     * @var collection $classes
     * @MongoDB\Field(type="collection")
     */
    protected $classes = array();
    
    /**
     * @var PHPOrchestraModel\MongoBundle\Document\Area
     * @MongoDB\EmbedMany(
     *  targetDocument="PHPOrchestraModel\MongoBundle\Document\Area"
     * )
     */
    protected $subAreas = array();
    
    /**
     * @var collection $blockReferences
     * @MongoDB\Field(type="collection")
     */
    protected $blockReferences = array();

    public function __construct()
    {
        $this->subAreas = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set htmlId
     *
     * @param string $htmlId
     * @return self
     */
    public function setHtmlId($htmlId)
    {
        $this->htmlId = $htmlId;
        return $this;
    }

    /**
     * Get htmlId
     *
     * @return string $htmlId
     */
    public function getHtmlId()
    {
        return $this->htmlId;
    }

    /**
     * Set boDirection
     *
     * @param string $boDirection
     * @return self
     */
    public function setBoDirection($boDirection)
    {
        $this->boDirection = $boDirection;
        return $this;
    }

    /**
     * Get boDirection
     *
     * @return string $boDirection
     */
    public function getBoDirection()
    {
        return $this->boDirection;
    }

    /**
     * Set boPercent
     *
     * @param float $boPercent
     * @return self
     */
    public function setBoPercent($boPercent)
    {
        $this->boPercent = $boPercent;
        return $this;
    }

    /**
     * Get boPercent
     *
     * @return float $boPercent
     */
    public function getBoPercent()
    {
        return $this->boPercent;
    }

    /**
     * Set classes
     *
     * @param collection $classes
     * @return self
     */
    public function setClasses($classes)
    {
        $this->classes = $classes;
        return $this;
    }

    /**
     * Get classes
     *
     * @return collection $classes
     */
    public function getClasses()
    {
        return $this->classes;
    }

    /**
     * Add subArea
     *
     * @param PHPOrchestraModel\MongoBundle\Document\Area $subArea
     */
    public function addSubArea(\PHPOrchestraModel\MongoBundle\Document\Area $subArea)
    {
        $this->subAreas[] = $subArea;
    }

    /**
     * Remove subArea
     *
     * @param PHPOrchestraModel\MongoBundle\Document\Area $subArea
     */
    public function removeSubArea(\PHPOrchestraModel\MongoBundle\Document\Area $subArea)
    {
        $this->subAreas->removeElement($subArea);
    }

    /**
     * Get subAreas
     *
     * @return Doctrine\Common\Collections\Collection $subAreas
     */
    public function getSubAreas()
    {
        return $this->subAreas;
    }

    /**
     * Set blockReferences
     *
     * @param collection $blockReferences
     * @return self
     */
    public function setBlockReferences($blockReferences)
    {
        $this->blockReferences = $blockReferences;
        return $this;
    }

    /**
     * Get blockReferences
     *
     * @return collection $blockReferences
     */
    public function getBlockReferences()
    {
        return $this->blockReferences;
    }
}
