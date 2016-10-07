<?php

namespace OpenOrchestra\FunctionalTests\Mapping\Metadata\Driver\FakeClass;

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
     * @ORCHESTRA\Search(key="fake_property3")
     */
    protected $fakeProperty2;
}
