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
	
	public function __construct()
	{
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
    	$this->blockReferences[] = array('node_id' => $nodeId, 'block_id' => $blockId);
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
    	           'area_id' => $this->getId(),
    	           'classes' => $this->getClasses(),
    	           'sub_areas' => $formattedSubAreas,
    	           'blocks' => $this->getBlockReferences()
    	);
    }
}