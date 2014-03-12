<?php

/*
 * Noël Gilain <noel.gilain@businessdecision.com>
 *
 * This class is the model class used to store areas and subareas in mandango Node objects
 * 
 */

namespace PHPOrchestra\CMSBundle\Classes;

class Area
{
	private $id = null;
	private $classes = array();
	private $subAreas = array();
	private $blockReferences = array();
	
	public function __construct($importArray = array())
	{
        if (is_array($importArray))
        {
           if (isset($importArray['areaId']))
                $this->id = $importArray['areaId'];
           
           if (isset($importArray['classes']) && is_array($importArray['classes']))
                 $this->classes = $importArray['classes'];
           
           if (isset($importArray['subAreas']) && is_array($importArray['subAreas']))
           	    foreach($importArray['subAreas'] as $subArea)
           	        $this->subAreas[] = new Area($subArea);
                 
           if (isset($importArray['blocks']) && is_array($importArray['blocks']))
                 $this->blockReferences = $importArray['blocks'];                 
		}
		return $this;
	}
	
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }
    
    public function addClass($class)
    {
        $this->classes[] = $class;
        return $this;
    }
    
    public function getClasses()
    {
    	return $this->classes;
    }
    
    public function addSubArea(Area $area)
    {
    	$this->subAreas[] = $area;
    	return $this;
    }
    
    public function getSubAreas()
    {
        return $this->subAreas;
    }
    
    public function addBlockReferences($nodeId, $blockId)
    {
    	$this->blockReferences[] = array('nodeId' => $nodeId, 'blockId' => $blockId);
    	return $this;
    }

    public function getBlockReferences()
    {
        return $this->blockReferences;
    }
    

    /**
     * Adapt area object to Areas attribute of mandango Node object
     */
    public function toArray()
    {
    	$formattedSubAreas = array();
    	
        foreach ($this->getSubAreas() as $area)
        	$formattedSubAreas[] = $area->toArray();

        return array(
    	           'areaId' => $this->getId(),
    	           'classes' => $this->getClasses(),
    	           'subAreas' => $formattedSubAreas,
    	           'blocks' => $this->getBlockReferences()
    	);
    }

}