<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Noël Gilain <noel.gilain@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use PHPOrchestra\CMSBundle\Classes\Area;

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
        
        if (isset($areas))
            $json = json_encode($areas);
        
        return $json;
    }

    /**
     * Transforms a json string to an array of Areas objects.
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
                $area = new Area($area);
                $nodeAreas[] = $area->toArray();
            }
               	
        return $nodeAreas;
    }
}