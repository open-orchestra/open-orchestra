<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Nicolas ANNE <nicolas.anne@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use PHPOrchestra\CMSBundle\Model\Area;

class NodeTypeTransformer implements DataTransformerInterface
{

	const BLOCK_GENERATE = 'generate';
    const BLOCK_LOAD = 'load';
    const JSON_AREA_TAG = 'areas';
    const PHP_AREA_TAG = 'subAreas';
    const CLASSES_TAG = 'classes';
    
    /**
     * Documents service
     * @var unknown
     */
    public $documentManager = null;

    /**
     * Constructor, require documentManager service
     * 
     * @param unknown $documentManager
     */
    public function __construct($documentManager)
    {
        $this->documentManager = $documentManager;
    }
    
	public function recTransform($values, $blocks)
    {
		foreach($values as $key => &$value){
			if($key === 'blocks'){
				foreach($value as &$block){
					if(array_key_exists('nodeId', $block) && array_key_exists('blockId', $block) && array_key_exists($block['blockId'], $blocks) && $block['nodeId'] === 0){
						$blockRef = $blocks[$block['blockId']];
						unset($block['blockId']);
						unset($block['nodeId']);
						$block['_method_'] = self::BLOCK_GENERATE;
                        $block['_component_'] = $blockRef->getComponent();
                        $block = array_merge($block, $blockRef->getAttributes());
					}
					else{
						$block['_method_'] = self::BLOCK_LOAD;
					}
				}
				if(sizeof($value) == 0){
					unset($values['blocks']);
				}
			}
			if($key == self::PHP_AREA_TAG){
		        foreach($value as &$area){
		            $area = $this->recTransform($area, $blocks);
		        }
                if(sizeof($value) == 0){
                    unset($values[self::PHP_AREA_TAG]);
                }
			}
		}
		return $values;
    }
    
    public function reverseRecTransform($values, &$node)
    {
        foreach($values as $key => &$value){
        	if($key === 'blocks'){
                foreach($value as &$block){
                    if(array_key_exists('_method_', $block) && $block['_method_'] === 'generate'){
                        $component = $block['_component_'];
                        unset($block['_method_']);
                        unset($block['_component_']);
                        unset($block['_token']);
                        $blockDoc = $this->documentManager->createDocument('Block')
                            ->setComponent($component)
                            ->setAttributes($block);
                        $block = array('nodeId' => 0, 'blockId' => $node->getBlocks()->count());
                        $node->addBlocks($blockDoc);
                    }
                    else{
                    	$block = array('nodeId' => $block['nodeId'], 'blockId' => $block['blockId']);
                    }
                }
        	}
            if($key == self::JSON_AREA_TAG){
                foreach($value as &$area){
                    $area = $this->reverseRecTransform($area, $node);
                }
                if(sizeof($value) == 0){
                    unset($values[self::PHP_AREA_TAG]);
                }
            }
        }
        return $values;
    }
    
	
    /**
     * Adapt a Php array to be exported to json
     * 
     * @param Array $area
     */
    protected function adaptArea($area)
    {
        $area[self::CLASSES_TAG] = implode(',', $area[self::CLASSES_TAG]);
        
        if (isset($area[self::PHP_AREA_TAG])) {
            foreach ($area[self::PHP_AREA_TAG] as $key => $subAreas) {
                $area[self::JSON_AREA_TAG][$key] = $this->adaptArea($subAreas);
            }
        }
        
        unset($area[self::PHP_AREA_TAG]);
        
        return $area;
    }
    
    /**
     * Adapt a Php array extracted from json
     * 
     * @param Array $area
     */
    protected function reverseAdaptArea($area)
    {
        if (array_key_exists(self::CLASSES_TAG, $area)) {
            $area[self::CLASSES_TAG] = explode(',', $area[self::CLASSES_TAG]);
        }
        if (isset($area[self::JSON_AREA_TAG])) {
            foreach ($area[self::JSON_AREA_TAG] as $key => $subAreas) {
                $area[self::PHP_AREA_TAG][$key] = $this->reverseAdaptArea($subAreas);
            }
        }
            
        unset($area[self::JSON_AREA_TAG]);
            
        return $area;
    }
    
	/**
     * Transforms a node
     *
     * @param object ContentType
     * @return object
     */
    public function transform($node)
    {
    	$areas = $node->getAreas();
    	$blocks = $node->getBlocks()->getSaved();
    	
    	if (isset($areas)) {
	    	foreach($areas as &$area){
	    		$area = $this->recTransform($area, $blocks);
	    		$area = $this->adaptArea($area);
	    	}
    	}
        $node->setAreas(json_encode($areas));

    	return $node;
    }

    /**
     * Transforms a node
     *
     * @param  object $datas
     * @return object
     */
    
    /**
     * Transforms a json string to an array of Areas array.
     *
     * @param  string $json
     * @return Area[]
     */
    public function reverseTransform($node)
    {
    	$areas = json_decode($node->getAreas(), true);
    	
    	$node->removeBlocks($node->getBlocks()->getSaved());
    	
    	$nodeAreas = array();
        if (is_array($areas)) {
            foreach ($areas as $area) {
            	$area = $this->reverseRecTransform($area, $node);
                $area = $this->reverseAdaptArea($area);
                $area = new Area($area);
                $nodeAreas[] = $area->toArray();
            }
        }
        
        $node->setAreas($nodeAreas);
        return $node;
    }    
}
