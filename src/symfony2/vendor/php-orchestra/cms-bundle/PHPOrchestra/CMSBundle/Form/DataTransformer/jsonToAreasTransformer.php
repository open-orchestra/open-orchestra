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

    const JSON_AREA_TAG = 'areas';
    const PHP_AREA_TAG = 'subAreas';
    const CLASSES_TAG = 'classes';
    
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
        $area[self::CLASSES_TAG] = implode(',', $area[self::CLASSES_TAG]);
        
        if (isset($area[self::PHP_AREA_TAG]))
            foreach ($area[self::PHP_AREA_TAG] as $key => $subAreas)
                $area[self::JSON_AREA_TAG][$key] = $this->adaptArea($subAreas);
        
        unset($area[self::PHP_AREA_TAG]);
        
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
        $area[self::CLASSES_TAG] = explode(',', $area[self::CLASSES_TAG]);
        
        if (isset($area[self::JSON_AREA_TAG]))
            foreach ($area[self::JSON_AREA_TAG] as $key => $subAreas)
                $area[self::PHP_AREA_TAG][$key] = $this->reverseAdaptArea($subAreas);
        
        unset($area[self::JSON_AREA_TAG]);
        
        return $area;
    }
}