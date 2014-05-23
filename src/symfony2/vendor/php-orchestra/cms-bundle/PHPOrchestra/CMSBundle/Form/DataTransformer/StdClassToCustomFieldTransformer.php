<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Noël Gilain <noel.gilain@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

class StdClassToCustomFieldTransformer implements DataTransformerInterface
{

    /**
     * Transforms a stdclass field to inject customfield options as standard fields
     *
     * @param object $datasFromJson
     * @return object
     */
	    public function transform($datasFromJson) // stdclass customField => formfield
    {
        $datas = (array) $datasFromJson;
        foreach ($datas['options'] as $optionName => $optionParameters) {
            $datas['option_' . $optionName] = $optionParameters;
        }
        unset($datas['options']);
        return (object) $datas;
    }

    /**
     * Transforms a form object in valid stdclass customfield
     *
     * @param  object
     * @return object
     */
    public function reverseTransform($datasFromForm) // formfield => stdclass customField
    {
        $datas = (array) $datasFromForm;
        
        foreach ($datas as $name => $value) {
            if (strpos($name, 'option_') === 0) {
                $datas['options'][str_replace('option_', '', $name)] = $value;
                unset($datas[$name]);
            }
        }
        
        return (object) $datas;
    }
}
