<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Noël Gilain <noel.gilain@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

class ContentTypeFieldsTransformer implements DataTransformerInterface
{

    /**
     * Transforms a ContentType entity to inject customfields as standard fields
     *
     * @param sring $jsonFields
     * @return array
     */
    public function transform($jsonFields) // entity => formfield
    {
        $formFields = array('jsonFields' => $jsonFields);
        
        $customFields = json_decode($jsonFields);
        
        if (is_array($customFields)) {
            foreach ($customFields as $key => $customField) {
                $formFields['customField_' . $key] = $customField;
            }
        }
        
        return $formFields;
    }

    /**
     * Transforms an object in valid ContentType entity.
     *
     * @param  array $formFields
     * @return string
     */
    public function reverseTransform($formFields) // formfield => entity
    {
        $jsonFields = json_decode($formFields['jsonFields']);
        
        $fields = array();
        for ($i = 0; $i < count($jsonFields); $i++) {
           $fields[] = $formFields['customField_' . $i];
        }
        
        return json_encode($fields);
    }
}
