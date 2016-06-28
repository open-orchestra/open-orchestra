<?php

namespace OpenOrchestra\Mapping\Tests\Functional\Mapping\Metadata\Driver;

use Metadata\Driver\FileLocator;
use OpenOrchestra\Mapping\Metadata\Driver\YamlDriver;

/**
 * Class YamlDriverTest
 */
class YamlDriverTest extends AbstractDriverTest
{
    /**
     * Set Up
     */
    public function setUp()
    {
        parent::setUp();
        $dirs = array('OpenOrchestra\Mapping\Tests\Functional\Mapping\Metadata\Driver\FakeClass' => __DIR__ . '/yml');
        $fileLocator = new FileLocator($dirs);

        $this->driver = new YamlDriver($fileLocator,
            $this->propertySearchMetadataFactory,
            $this->mergeableClassMetadataFactory
        );
    }
}
