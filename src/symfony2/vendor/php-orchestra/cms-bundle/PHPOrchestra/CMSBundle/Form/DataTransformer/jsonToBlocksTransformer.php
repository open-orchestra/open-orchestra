<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Noël Gilain <noel.gilain@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Mandango;

class jsonToBlocksTransformer implements DataTransformerInterface
{
    /**
     * Mandango service
     * @var Mandango\Mandango
     */
    var $mandango = null;
    
    
    /**
     * Constructor, require mandango service
     * 
     * @param Mandango\Mandango $mandango
     */
    public function __construct(Mandango\Mandango $mandango)
    {
        $this->mandango = $mandango;
    }

    /**
     * Transforms an EmbeddedGroup to a json string.
     *
     * @param  EmbeddedGroup|null $blocks
     * @return string
     */
    public function transform($blocks)
    {
        if (isset($blocks))
            $blocks = $blocks->getSaved();
        else
            $blocks = array();
            
        $blocksArray = array();
        
        foreach ($blocks as $block)
            $blocksArray[] = array(
                            'component' => $block->getComponent(),
                            'attributes' => $block->getAttributes()
                         );

        return json_encode($blocksArray);
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