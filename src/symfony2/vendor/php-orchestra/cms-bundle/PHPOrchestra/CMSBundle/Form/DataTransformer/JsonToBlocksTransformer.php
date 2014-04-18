<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Noël Gilain <noel.gilain@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

class JsonToBlocksTransformer implements DataTransformerInterface
{
    /**
     * Documents service
     * @var unknown
     */
    public $documentLoader = null;
    
    
    /**
     * Constructor, require documentLoader service
     * 
     * @param unknown $documentLoader
     */
    public function __construct($documentLoader)
    {
        $this->documentLoader = $documentLoader;
    }

    /**
     * Transforms an EmbeddedGroup to a json string.
     *
     * @param  \Mandango\Group\EmbeddedGroup|null $blocks
     * @return string
     */
    public function transform($blocks)
    {
        if (isset($blocks)) {
            $blocks = $blocks->getSaved();
        } else {
            $blocks = array();
        }
            
        $blocksArray = array();
        
        foreach ($blocks as $block) {
            $blocksArray[] = array(
                            'component' => $block->getComponent(),
                            'attributes' => $block->getAttributes()
                        );
        }

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
            foreach ($blocks as $block) {
                $blockDoc = $this->documentLoader->createDocument('Block')
                    ->setComponent($block['component'])
                    ->setAttributes($block['attributes']);
                $docsArray[] = $blockDoc;
            }
        }
        
        return $docsArray;
    }
}
