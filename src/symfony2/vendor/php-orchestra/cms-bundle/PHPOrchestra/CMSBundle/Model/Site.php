<?php

namespace PHPOrchestra\CMSBundle\Model;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Model\PHPOrchestraCMSBundle\Site bundle document.
 */
abstract class Site extends \Model\PHPOrchestraCMSBundle\Base\Site
{
    
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        Site::loadClassMetadata($metadata);
    }
    public static function loadClassMetadata(ClassMetadata $metadata)
    {
        $metadata->addGetterConstraint('domain', new NotBlank());
    }
    

    public function setLanguages($value)
    {
          $value = (is_array($value)) ? implode(',', $value) : $value;
        parent::setLanguages($value);
    }
    
    public function getLanguages()
    {
        $value = parent::getLanguages();
        $value = (is_string($value)) ? explode(',', $value) : array();
        return $value;
    }
    
    public function setBlocks($value)
    {
        $value = (is_array($value)) ? implode(',', $value) : $value;
        parent::setBlocks($value);
    }
    
    public function getBlocks()
    {
        $value = parent::getBlocks();
        $value = (is_string($value)) ? explode(',', $value) : array();
        return $value;
    }
}
