<?php

namespace OpenOrchestra\Mapping\Tests\Functional\Mapping\Metadata\Driver\FakeClass;

use OpenOrchestra\Mapping\Annotations as ORCHESTRA;

/**
 * Class FakeClassMetadata
 */
class FakeClassMetadata
{
    /**
     * @ORCHESTRA\Search(
     *      type="fakeType",
     *      key="fake_property1",
     *      field="fakeProperty1"
     * )
     */
    protected $fakeProperty1;

    /**
     * @ORCHESTRA\Search(key={"fake_property2", "fake_property_multi"})
     */
    protected $fakeProperty2;
}
