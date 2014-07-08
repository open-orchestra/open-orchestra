<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Noël Gilain <noel.gilain@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

class MultilingualTextTransformer implements DataTransformerInterface
{
    private $availableLanguages = array();
    
    /**
     * Constructor
     * 
     * @param array $availableLanguages
     */
    public function __construct($availableLanguages)
    {
        $this->availableLanguages = $availableLanguages;
    }

    /**
     * (non-PHPdoc)
     * @see src/symfony2/vendor/symfony/symfony/src/Symfony/Component/Form/
     * Symfony\Component\Form.DataTransformerInterface::transform()
     */
    public function transform($jsonLanguages) // entity => formfield
    {
        $formLanguages = array();
        $languages = (array) json_decode($jsonLanguages);
        
        if (is_array($languages)) {
            foreach ($languages as $language => $name) {
                if (isset($this->availableLanguages[$language])) {
                    $this->availableLanguages[$language] = $name;
                }
            }
        }
        
        foreach ($this->availableLanguages as $language => $value) {
            $formLanguages['language_' . $language] = $value;
        }
        
        return $formLanguages;
    }

    /**
     * (non-PHPdoc)
     * @see src/symfony2/vendor/symfony/symfony/src/Symfony/Component/Form/
     * Symfony\Component\Form.DataTransformerInterface::reverseTransform()
     */
    public function reverseTransform($formLanguages) // formfield => entity
    {
        $languages = array();
        
        if (is_array($formLanguages)) {
            foreach ($formLanguages as $language_id => $value) {
                if (substr($language_id, 0, 9) == 'language_') {
                    $languages[substr($language_id, 9)] = $value;
                }
            }
        }
        
        return json_encode($languages);
    }
}
