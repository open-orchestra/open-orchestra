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
    private $htmlId = null;
    
    /**
     * bo direction (horizontal, vertical)
     * 
     * @var string
     */
    private $boDirection = null;
    
    /**
     * html classes
     * 
     * @var string[]
     */
    private $classes = array();
    
    /**
     * sub areas
     * 
     * @var Area[]
     */
    private $subAreas = array();
    
    /**
     * References array to blocks defined in external nodes
     * 
     * @var array
     */
    private $blockReferences = array();
    
    
    /**
     * Constructor
     * 
     * @param array $importArray
     */
    public function __construct(array $importArray = array())
    {
        if (isset($importArray['areaId']))
            $this->htmlId = $importArray['areaId'];
        
        if (isset($importArray['boDirection']))
            $this->boDirection = $importArray['boDirection'];
        
        if (isset($importArray['classes']))
            $this->classes = $importArray['classes'];
        
        if (isset($importArray['subAreas']) && is_array($importArray['subAreas']))
            foreach($importArray['subAreas'] as $subArea)
                $this->subAreas[] = new Area($subArea);
        
        if (isset($importArray['blocks']) && is_array($importArray['blocks']))
            $this->blockReferences = $importArray['blocks'];                 
        
        return $this;
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
        
        foreach ($this->getSubAreas() as $area)
            $formattedSubAreas[] = $area->toArray();
        
        return array(
                   'areaId' => $this->getHtmlId(),
                   'boDirection' => $this->getBoDirection(),
                   'classes' => $this->classes,
                   'subAreas' => $formattedSubAreas,
                   'blocks' => $this->getBlockReferences()
        );
    }

}