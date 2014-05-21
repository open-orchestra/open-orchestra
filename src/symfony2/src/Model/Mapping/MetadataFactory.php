<?php

namespace Model\Mapping;

class MetadataFactory extends \Mandango\MetadataFactory
{
    protected $classes = array(
        'Model\\PHPOrchestraCMSBundle\\Site' => false,
        'Model\\PHPOrchestraCMSBundle\\Block' => true,
        'Model\\PHPOrchestraCMSBundle\\Node' => false,
        'Model\\PHPOrchestraCMSBundle\\Template' => false,
        'Model\\PHPOrchestraCMSBundle\\ContentAttribute' => true,
        'Model\\PHPOrchestraCMSBundle\\Content' => false,
        'Model\\PHPOrchestraCMSBundle\\ContentType' => false,
        'Model\\PHPOrchestraCMSBundle\\User' => false,
    );
}
