<?php

namespace Model\Mapping;

class MetadataFactory extends \Mandango\MetadataFactory
{
    protected $classes = array(
        'Model\\PHPOrchestraCMSBundle\\Site' => false,
        'Model\\PHPOrchestraCMSBundle\\Node' => false,
        'Model\\PHPOrchestraCMSBundle\\Content' => false,
        'Model\\PHPOrchestraCMSBundle\\User' => false,
    );
}