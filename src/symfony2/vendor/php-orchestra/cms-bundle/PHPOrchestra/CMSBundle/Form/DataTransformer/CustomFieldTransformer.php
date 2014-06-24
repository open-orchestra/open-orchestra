<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Noël Gilain <noel.gilain@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

class CustomFieldTransformer implements DataTransformerInterface
{
    /**
     * Transforms a stdclass field to inject customfield options in form
     *
     * @param object $datas
     * @return object
     */
    public function transform($datas) // stdclass customField => formfield
    {
        $datas = (array) $datas;
        if (isset($datas['options'])) {
            foreach ($datas['options'] as $optionName => $optionParameters) {
                $datas['option_' . $optionName] = $optionParameters;
            }
        }
        unset($datas['options']);
        $datas['removeField'] = false;
        return (object) $datas;
    }

    /**
     * Transforms a form object into a valid stdclass customfield
     *
     * @param  object
     * @return object
     */
    public function reverseTransform($customFieldObject) // formfield => stdclass customField
    {
        $customField = (array) $customFieldObject;
        
        foreach ($customField as $paramName => $paramValue) {
            if (strpos($paramName, 'option_') === 0) {
                $customField['options'][str_replace('option_', '', $paramName)] = $paramValue;
                unset($customField[$paramName]);
            }
        }
        
        return (object) $customField;
    }
}
