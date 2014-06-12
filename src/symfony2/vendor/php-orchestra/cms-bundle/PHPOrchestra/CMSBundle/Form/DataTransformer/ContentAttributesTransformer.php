<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Noël Gilain <noel.gilain@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

class ContentAttributesTransformer implements DataTransformerInterface
{
    protected $documentManager = null;
    protected $fieldsStructure = null;

    public function __construct($documentManager, $fieldsStructure)
    {
        $this->documentManager = $documentManager;
        $this->fieldsStructure = $fieldsStructure;
    } 

    /**
     * Transforms a ContentAttributes entity to inject attributeFields
     *
     * @param object ContentType
     * @return object
     */
    public function transform($attributes) // entity => formfield
    {
        $formAttributes = array();
        
        // Fields default values
        foreach ($this->fieldsStructure as $fieldStructure)
        {
            $name = $fieldStructure->fieldId;
            $attributes->$name = 0; // <= CHANGE THIS WITH A DEFAULT VALUE EDITED IN CONTENTTYPE FORM
        }
        
        // Fields edited values
        foreach ($attributes as $key => $attribute) {
            $name = $attribute->getName();
            $attributes->$name = $attribute->getValue();
        }
        return $attributes;
    }

    /**
     * Transforms an object in valid ContentAttributes entity.
     *
     * @param  object
     * @return object
     */
    public function reverseTransform($attributes) // formfield => entity
    {
        $newAttributes = array();
        
        foreach ($this->fieldsStructure as $fieldStructure)
        {
            $attribute = $this->documentManager->createDocument('ContentAttribute');
            $name = $fieldStructure->fieldId;
            $attribute->setName($name);
            $attribute->setValue($attributes->$name);
            $newAttributes[] = $attribute;
        }
        return $newAttributes;
    }
}
