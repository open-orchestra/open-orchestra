<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Noël Gilain <noel.gilain@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

class ContentTypeTransformer implements DataTransformerInterface
{
    /**
     * Transforms a ContentType entity to inject customfields as standard fields
     *
     * @param object ContentType
     * @return object
     */
    public function transform($contentType) // entity => formfield
    {
        $contentType->new_field = '';
        
        return $contentType;
    }

    /**
     * Transforms an object in valid ContentType entity.
     *
     * @param  object $contentType
     * @return object
     */
    public function reverseTransform($contentType) // formfield => entity
    {
        if ($contentType->new_field != '') {
            $fields = json_decode($contentType->getFields());
            
            $fields[] = (object) array(
                'fieldId' => '',
                'label' => '',
                'defaultValue' => '',
                'searchable' => false,
                'type' => $contentType->new_field,
                'symfonyType' => '',
                'options' => (object) array()
            );
            $contentType->setFields(json_encode($fields));
        }
        
        return $contentType;
    }
}
