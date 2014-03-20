<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Noël Gilain <noel.gilain@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

class jsonToBlocksTransformer implements DataTransformerInterface
{

    var $mandango = null;
    
    public function __construct($mandango)
    {
        $this->mandango = $mandango;
    }

    /**
     * Transforms *** to a json string.
     *
     * @param  ***|null $blocks
     * @return string
     */
    public function transform($blocks)
    {
    	$json = "";
    	if (isset($blocks))
            $json = json_encode($blocks);
        return $json;
    }

    /**
     * Transforms a json string to an array of Block objects.
     *
     * @param  string $json
     * @return Block[]
     */
    public function reverseTransform($json)
    {
        $blocks = json_decode($json, true);
        $docsArray = array();

        if (is_array($blocks)) {
            foreach($blocks as $block) {
                $blockDoc = $this->mandango->create('Model\PHPOrchestraCMSBundle\Block')
                    ->setComponent($block['component'])
                    ->setAttributes($block['attributes']);
                $docsArray[] = $blockDoc;
            }
        }
        
        return $docsArray;
    }
}