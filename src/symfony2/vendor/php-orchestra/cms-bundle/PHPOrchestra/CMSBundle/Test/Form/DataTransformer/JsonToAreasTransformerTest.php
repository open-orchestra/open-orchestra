<?php

namespace PHPOrchestra\CMSBundle\Test\Form\DataTransformer;

use \PHPOrchestra\CMSBundle\Form\DataTransformer\JsonToAreasTransformer;

/**
 * Description of JsonToAreasTransformerTest
 *
 * @author nbouquet
 */
class JsonToAreasTransformerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Transformer object to test
     * 
     * @var \PHPOrchestra\CMSBundle\Form\DataTransformer\JsonToAreasTransformer
     */
    protected $transformer;
    
    /**
     * Initializes the transformer to be tested
     */
    public function setUp()
    {
        parent::setUp();
        
        $this->transformer = new JsonToAreasTransformer;
    }
    
    /**
     * Test Areas to Json transformation
     * 
     * @dataProvider jsonToAreasData
     * @param type $expectedJson
     * @param type $areas
     */
    public function testTransform($areas, $expectedJson)
    {
        $result = $this->transformer->transform($areas);
        
        $this->assertEquals($expectedJson, $result);
        
    }
    
    /**
     * Test Json to Areas transformation
     * 
     * @dataProvider jsonToAreasData
     * @param type $expectedJson
     * @param type $areas
     */
    public function testReverseTransform($expectedAreas, $json)
    {
        $result = $this->transformer->reverseTransform($json);
        $this->assertEquals($expectedAreas, $result);
        
    }
    
    /**
     * Data provider
     */
    public function jsonToAreasData()
    {
        return array(
            array(
                array(
                    array(
                        'areaId' => 'SimpleArea',
                        'boDirection' => null,
                        'boPercent' => null,
                        'classes' =>
                        array(
                            0 => 'class1',
                            1 => 'class2',
                        ),
                        'subAreas' =>
                        array(
                        ),
                        'blocks' =>
                        array(
                        ),
                    ),
                ),
                '[{"areaId":"SimpleArea","boDirection":null,"boPercent":null,"classes":"class1,class2","blocks":[]}]'
            )
        );
    }
}
