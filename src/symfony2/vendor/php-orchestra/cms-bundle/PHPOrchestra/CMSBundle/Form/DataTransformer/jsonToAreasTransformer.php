<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Noël Gilain <noel.gilain@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use PHPOrchestra\CMSBundle\Model\Area;

class jsonToAreasTransformer implements DataTransformerInterface
{

    /**
     * Transforms an array of areas to a json string.
     *
     * @param  string[]|null $areas
     * @return string
     */
    public function transform($areas)
    {
        $json = "[]";
        
        if (isset($areas)) {
            foreach($areas as $key => $area)
                $areas[$key] = $this->adaptArea($area);
            $json = json_encode($areas);
        }
        
        return $json;
    }

    /**
     * Adapt a Php array to be exported to json
     * 
     * @param Array $area
     */
    protected function adaptArea($area)
    {
        $area['classes'] = implode(',', $area['classes']);
        
        if (isset($area['subAreas']))
            foreach ($area['subAreas'] as $key => $subAreas)
                $area['area'][$key] = $this->adaptArea($subAreas);
        
        unset($area['subAreas']);
        
        return $area;
    }
    
    /**
     * Transforms a json string to an array of Areas array.
     *
     * @param  string $json
     * @return Area[]
     */
    public function reverseTransform($json)
    {
        $areas = json_decode($json, true);
        
        $nodeAreas = array();
        if (is_array($areas))
            foreach($areas as $area) {
                $area = $this->reverseAdaptArea($area);
                $area = new Area($area);
                $nodeAreas[] = $area->toArray();
            }
        
        return $nodeAreas;
    }

    /**
     * Adapt a Php array extracted from json
     * 
     * @param Array $area
     */
    protected function reverseAdaptArea($area)
    {
        $area['classes'] = explode(',', $area['classes']);
        
        if (isset($area['area']))
            foreach ($area['area'] as $key => $subAreas)
                $area['subAreas'][$key] = $this->reverseAdaptArea($subAreas);
        
        unset($area['area']);
        
        return $area;
    }
}