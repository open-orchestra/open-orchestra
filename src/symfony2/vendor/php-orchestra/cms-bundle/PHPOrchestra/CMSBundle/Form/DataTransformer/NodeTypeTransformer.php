<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Nicolas ANNE <nicolas.anne@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use PHPOrchestra\CMSBundle\Model\Area;
use PHPOrchestra\CMSBundle\Form\Type\BlockType;
use PHPOrchestra\CMSBundle\Form\Type\AreaType;
use Symfony\Component\Form\ResolvedFormTypeInterface;
use PHPOrchestra\CMSBundle\Controller\BlockController;
use Symfony\Component\HttpFoundation\Request;

class NodeTypeTransformer implements DataTransformerInterface
{

    const BLOCK_GENERATE = 'generate';
    const BLOCK_LOAD = 'load';
    const JSON_AREA_TAG = 'areas';
    const PHP_AREA_TAG = 'subAreas';
    const CLASSES_TAG = 'classes';

    protected $isNode = false;
    /**
    * container service
    * @var container
    */
    protected $container = null;

    /**
     * Constructor
     * 
     * @param $container
     * @param $isNode
     */
    
    public function __construct($container, $isNode)
    {
        $this->container = $container;
        $this->isNode = $isNode;
    }
    
    public function getInformationsFromType($form)
    {
    	$result = array();
        $children = $form->all();
        foreach($children as $child){
            $config = $child->getConfig();
        	$attributs = $config->getAttribute("data_collector/passed_options");
            if(is_array($attributs) && array_key_exists('attr', $attributs) && array_key_exists('class', $attributs['attr']) && strpos($attributs['attr']['class'], 'used-as-label') !== false){
                $result['label'] = $child->getData();
                $options = $config->getOption('choices');
                if($options !== null && array_key_exists($child->getData(), $options)){
                	$result['label'] = $options[$child->getData()];
                }
            }
        }
        return $result;
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
                        $block['method'] = self::BLOCK_GENERATE;
                        $block['component'] = $blockRef->getComponent();
                        $attributs = $blockRef->getAttributes();
                        $attributs = array_combine(array_map(function($value) { return 'attributs_'.$value; }, array_keys($attributs)), array_values($attributs));
                        $block = array_merge($block, $attributs);
                    }
                    else{
                        $block['method'] = self::BLOCK_LOAD;
                    }
                    $request = new Request(array(), $block);
                    $form = $this->container->get('form.factory')->create(new BlockType($this->container->get('phporchestra_cms.documentmanager')), array_merge($block, array('is_node' => $this->isNode)));
                    $block['ui-model'] = $this->getInformationsFromType($form);
                    $blockController = $this->container->get('phporchestra_cms.blockcontroller');
                    $blockController->setContainer($this->container);
                    $response = json_decode($blockController->getPreview($request)->getContent(), true);
                    if(is_array($response) && array_key_exists('data', $response)){
                    	$block['ui-model']['html'] = $response['data'];
                    }
                }
                if(count($value) == 0){
                    unset($values['blocks']);
                }
            }
            if($key == self::PHP_AREA_TAG){
                foreach($value as &$area){
                    $area = $this->recTransform($area, $blocks);
                    $area[self::CLASSES_TAG] = implode(',', $area[self::CLASSES_TAG]);
                    $form = $this->container->get('form.factory')->create(new AreaType($this->container->get('phporchestra_cms.documentmanager')), $area);
                    $area['ui-model'] = $this->getInformationsFromType($form);
                }
                if(count($value) > 0){
                    $values[self::JSON_AREA_TAG] = $value;
                }
                unset($values[self::PHP_AREA_TAG]);
            }
        }
        return $values;
    }
    
    public function reverseRecTransform($values, &$node)
    {
        foreach($values as $key => &$value){
            if($key === 'blocks'){
                foreach($value as &$block){
                    if(array_key_exists('method', $block) && $block['method'] === 'generate'){
                        $component = $block['component'];
                        unset($block['method']);
                        unset($block['component']);
                        unset($block['_token']);
                        unset($block['ui-model']);
                        $attributs = $block;
                        $attributs = array_combine(array_map(function($value) { return preg_replace('/^attributs_/', '', $value); }, array_keys($attributs)), array_values($attributs));
                        $blockDoc = $this->container->get('phporchestra_cms.documentmanager')->createDocument('Block')
                            ->setComponent($component)
                            ->setAttributes($attributs);
                        $block = array('nodeId' => 0, 'blockId' => $node->getBlocks()->count());
                        $node->addBlocks($blockDoc);
                    }
                    elseif(array_key_exists('nodeId', $block) && array_key_exists('blockId', $block)){
                        $block = array('nodeId' => $block['nodeId'], 'blockId' => $block['blockId']);
                    }
                }
            }
            if($key == self::JSON_AREA_TAG){
                foreach($value as &$area){
                    $area = $this->reverseRecTransform($area, $node);
                    $area[self::CLASSES_TAG] = explode(',', $area[self::CLASSES_TAG]);
                    unset($area['ui-model']);
                }
                $values[self::PHP_AREA_TAG] = $value;
                unset($values[self::JSON_AREA_TAG]);
            }
        }
        return $values;
    }
    
    /**
     * Transforms a node
     *
     * @param object NodeType
     * @return object
     */
    public function transform($node)
    {
    	if(isset($node)){
	        $areas = $node->getAreas();
	        $blocks = $node->getBlocks()->getSaved();
	        if (isset($areas)) {
	            $areas = array(self::PHP_AREA_TAG => $node->getAreas());
	            $areas = $this->recTransform($areas, $blocks);
	        }
	        $node->setAreas(json_encode($areas));
    	}
        return $node;
    }

    /**
     * Transforms a json string to a node.
     *
     * @param  string $json
     * @return Node
     */
    public function reverseTransform($node)
    {
    	if(isset($node)){
    		$areas = json_decode($node->getAreas(), true);
	        $node->removeBlocks($node->getBlocks()->getSaved());
	        if (is_array($areas)) {
	        	$areas = array(self::JSON_AREA_TAG => $areas);
	            $areas = $this->reverseRecTransform($areas, $node);
	            $node->setAreas($areas[self::PHP_AREA_TAG]);
	        }
    	}
        return $node;
    }    
}
