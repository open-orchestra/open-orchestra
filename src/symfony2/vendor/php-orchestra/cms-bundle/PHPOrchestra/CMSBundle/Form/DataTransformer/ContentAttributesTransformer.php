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

    /**
     * Constructor
     * 
     * @param unknown_type $documentManager
     * @param unknown_type $fieldsStructure
     */
    public function __construct($documentManager, $fieldsStructure)
    {
        $this->documentManager = $documentManager;
        $this->fieldsStructure = $fieldsStructure;
    }

    /**
     * Transforms a ContentAttributes entity to inject attributeFields
     *
     * @param object $attributes
     */
    public function transform($attributes) // entity => formfield
    {
        // Fields default values
        foreach ($this->fieldsStructure as $fieldStructure) {
            if (is_object($fieldStructure)
                && isset($fieldStructure->fieldId)
            ) {
                $name = $fieldStructure->fieldId;
                $attributes->$name = $fieldStructure->defaultValue;
            }
        }
        
        // Fields edited values
        foreach ($attributes as $attribute) {
            if (is_object($attribute)
                && method_exists($attribute, 'getName')
                && method_exists($attribute, 'getValue')
            ) {
                $name = $attribute->getName();
                $attributes->$name = $attribute->getValue();
            }
        }
        
        return $attributes;
    }

    /**
     * Transforms an object $attributes in valid ContentAttributes entity.
     *
     * @param  object $attributes
     */
    public function reverseTransform($attributes) // formfield => entity
    {
        $newAttributes = array();
        
        foreach ($this->fieldsStructure as $fieldStructure) {
            if (is_object($fieldStructure)
                && isset($fieldStructure->fieldId)
                && isset($fieldStructure->defaultValue)
                && is_object($attributes)
            ) {
                $attribute = $this->documentManager->createDocument('ContentAttribute');
                $name = $fieldStructure->fieldId;
                $attribute->setName($name);
                $attribute->setValue($fieldStructure->defaultValue);
                if (isset($attributes->$name)) {
                    $attribute->setValue($attributes->$name);
                }
                $newAttributes[] = $attribute;
                unset($attribute);
            }
        }
        
        return $newAttributes;
    }
}
