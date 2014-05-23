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
        $customFields = json_decode($contentType->getFields());
        
        $customFieldsIndex = array();
        foreach ($customFields as $key => $customField) {
            $varName = 'customField_' . $key;
            $contentType->$varName = $customField;
            $customFieldsIndex[] = $varName;
        }
        $contentType->customFieldsIndex = $customFieldsIndex;
        return $contentType;
    }

    /**
     * Transforms an object in valid ContentType entity.
     *
     * @param  object
     * @return object
     */
    public function reverseTransform($datas) // formfield => entity
    {
        $fields = array();
        foreach ($datas->customFieldsIndex as $index) {
            $fields[] = $datas->$index;
        }
        $datas->setFields(json_encode($fields));
        
        return $datas;
    }
}
