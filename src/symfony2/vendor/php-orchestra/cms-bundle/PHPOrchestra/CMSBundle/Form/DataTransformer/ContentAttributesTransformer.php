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

    /**
     * Transforms a ContentAttributes entity to inject attributeFields
     *
     * @param object ContentType
     * @return object
     */
    public function transform($attributes) // entity => formfield
    {
        //print_r($attributes);exit();
        $formAttributes = array();
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
    public function reverseTransform($datas) // formfield => entity
    {
/*        $fields = array();
        foreach ($datas->customFieldsIndex as $index) {
            if (!is_null($datas->$index)) {
                $fields[] = $datas->$index;
            }
        }
        if ($datas->new_field != '') {
            $fields[] = (object) array(
                "fieldId" => "",
                "label" => "",
                "searchable" => false,
                "type" => $datas->new_field,
                "options" => (object) array()
            );
        }
        
        $datas->setFields(json_encode($fields));
        return $datas;*/
    	return null;
    }
}
