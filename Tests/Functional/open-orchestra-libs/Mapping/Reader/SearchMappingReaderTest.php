<?php

namespace OpenOrchestra\Mapping\Tests\Functional\Mapping\Reader;

use OpenOrchestra\Mapping\Annotations as ORCHESTRA;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use ReflectionObject;

/**
 * Class SearchMappingReaderTest
 */
class SearchMappingReaderTest extends KernelTestCase
{
    protected $readerSearch;
    protected $fakeClass;

    /**
     * setUp
     */
    public function setUp()
    {
        $this->fakeClass = new FakeClassAnnotation();

        static::bootKernel();
        $this->readerSearch = static::$kernel->getContainer()->get('open_orchestra.annotation_search_reader');
    }

    /**
     * Test ExtractMapping
     */
    public function testExtractMapping()
    {
        $mappingProperties = array(
            "fake_property1" =>array(
                "key" => "fake_property1",
                "field" => "fakeProperty1",
                "type" => "fakeType",
            ),
            "fake_property2" =>array(
                "key" => "fake_property2",
                "field" => "fakeProperty2",
                "type" => "string",
            ),
            "fake_property_multi" =>array(
                "key" => "fake_property_multi",
                "field" => "fakeProperty2",
                "type" => "string",
            )
        );

        $mapping = $this->readerSearch->extractMapping(get_class($this->fakeClass));
        $this->assertCount(3, $mapping);
        $this->assertSame($mapping, $mappingProperties);
    }

    /**
     * Clean up
     */
    protected function tearDown()
    {
        $refl = new ReflectionObject($this);
        foreach ($refl->getProperties() as $prop) {
            if (!$prop->isStatic() && 0 !== strpos($prop->getDeclaringClass()->getName(), 'PHPUnit_')) {
                $prop->setAccessible(true);
                $prop->setValue($this, null);
            }
        }
    }
}

/**
 * Class FakeClassAnnotation
 */
class FakeClassAnnotation
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
