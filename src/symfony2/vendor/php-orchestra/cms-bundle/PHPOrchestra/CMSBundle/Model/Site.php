<?php

namespace PHPOrchestra\CMSBundle\Model;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Model\PHPOrchestraCMSBundle\Site bundle document.
 */
abstract class Site extends \Model\PHPOrchestraCMSBundle\Base\Site
{
	
    public static function loadValidatorMetadata(ClassMetadata $metadata){
        Site::loadClassMetadata($metadata);
    }
	public static function loadClassMetadata(ClassMetadata $metadata)
    {
    	$metadata->addGetterConstraint('domain', new NotBlank());
    }
	
}
