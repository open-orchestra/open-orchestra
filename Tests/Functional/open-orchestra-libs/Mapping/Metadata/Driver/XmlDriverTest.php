<?php

namespace OpenOrchestra\Mapping\Tests\Functional\Mapping\Metadata\Driver;

use Metadata\Driver\FileLocator;
use OpenOrchestra\Mapping\Metadata\Driver\XmlDriver;

/**
 * Class XmlDriverTest
 */
class XmlDriverTest extends AbstractDriverTest
{
    /**
     * Set Up
     */
    public function setUp()
    {
        parent::setUp();
        $dirs = array('OpenOrchestra\Mapping\Tests\Functional\Mapping\Metadata\Driver\FakeClass' => __DIR__ . '/xml');
        $fileLocaltor = new FileLocator($dirs);

        $this->driver = new XmlDriver($fileLocaltor,
            $this->propertySearchMetadataFactory,
            $this->mergeableClassMetadataFactory
        );
    }
}
