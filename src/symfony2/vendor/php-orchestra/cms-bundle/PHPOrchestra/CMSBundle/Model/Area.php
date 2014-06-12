<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Noël Gilain <noel.gilain@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Model;

class Area
{
    /**
     * html identifier
     * 
     * @var string
     */
    protected $htmlId = null;
    
    /**
     * bo direction (horizontal, vertical)
     * 
     * @var string
     */
    protected $boDirection = null;
    
    /**
     * percent
     * 
     * @var float
     */
    protected $boPercent = null;
    
    /**
     * html classes
     * 
     * @var string[]
     */
    protected $classes = array();
    
    /**
     * sub areas
     * 
     * @var Area[]
     */
    protected $subAreas = array();
    
    /**
     * References array to blocks defined in external nodes
     * 
     * @var array
     */
    protected $blockReferences = array();
    
    
    /**
     * Constructor
     * 
     * @param array $importArray
     */
    public function __construct(array $importArray = array())
    {
        $fields = array('areaId', 'boDirection', 'boPercent', 'classes',
            'subAreas', 'blocks');
        
        foreach ($importArray as $field => $value) {
            if (in_array($field, $fields)) {
                $setter = 'set' . ucfirst($field);
                $this->$setter($value);
            }
        }
    }
    
    /**
     * Set htmlId
     * 
     * @param string $htmlId
     */
    public function setHtmlId($htmlId)
    {
        $this->htmlId = $htmlId;
        return $this;
    }

    /**
     * Get htmlId
     */
    public function getHtmlId()
    {
        return $this->htmlId;
    }
    
    /**
     * Set areaId
     * 
     * @param string $areaId
     */
    public function setAreaId($areaId)
    {
        return $this->setHtmlId($areaId);
    }

    /**
     * Get areaId
     */
    public function getAreaId()
    {
        return $this->getHtmlId();
    }
    
    /**
     * Set boDirection
     * 
     * @param string $boDirection
     */
    public function setBoDirection($boDirection)
    {
        $this->boDirection = $boDirection;
        return $this;
    }

    /**
     * Get BoDirection
     */
    public function getBoDirection()
    {
        return $this->boDirection;
    }
    
    /**
     * Set boPercent
     * 
     * @param string $boPercent
     */
    public function setBoPercent($boPercent)
    {
        $this->boPercent = $boPercent;
        return $this;
    }

    /**
     * Get boPercent
     */
    public function getBoPercent()
    {
        return $this->boPercent;
    }
    
    
    /**
     * Add a html class
     * 
     * @param string $class
     */
    public function addClass($class)
    {
        $this->classes[] = $class;
        return $this;
    }
    
    /**
     * Set classes
     * 
     * @param array $classes
     * @return \PHPOrchestra\CMSBundle\Model\Area
     */
    public function setClasses($classes)
    {
        $this->classes = $classes;
        return $this;
    }

    /**
     * Add a sub area
     * 
     * @param Area $area
     */
    public function addSubArea(Area $area)
    {
        $this->subAreas[] = $area;
        return $this;
    }

    /**
     * Get sub areas
     */
    public function getSubAreas()
    {
        return $this->subAreas;
    }

    /**
     * Set sub areas
     * Return self, fluent interface
     * 
     * @return \PHPOrchestra\CMSBundle\Model\Area
     */
    public function setSubAreas($subAreas)
    {
        foreach ($subAreas as $subArea) {
            $this->subAreas[] = new Area($subArea);
        }
        return $this;
    }

    /**
     * Set blocks
     * 
     * @param unknown_type $blocks
     */
    public function setBlocks($blocks)
    {
        $this->blockReferences = $blocks;
    }

    /**
     * Add an external block reference
     * 
     * @param int $nodeId
     * @param int $blockId
     */
    public function addBlockReferences($nodeId, $blockId)
    {
        $this->blockReferences[] = array('nodeId' => $nodeId, 'blockId' => $blockId);
        return $this;
    }

    /**
     * get block references
     */
    public function getBlockReferences()
    {
        return $this->blockReferences;
    }

    /**
     * Adapt area from object to array
     */
    public function toArray()
    {
        $formattedSubAreas = array();
        
        foreach ($this->getSubAreas() as $area) {
            $formattedSubAreas[] = $area->toArray();
        }
        
        return array(
            'areaId' => $this->getHtmlId(),
            'boDirection' => $this->getBoDirection(),
            'boPercent' => $this->getBoPercent(),
            'classes' => $this->classes,
            'subAreas' => $formattedSubAreas,
            'blocks' => $this->getBlockReferences()
        );
    }
}
