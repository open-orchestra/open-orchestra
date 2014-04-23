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
        
        $this->assertJsonStringEqualsJsonString($expectedJson, $result);
        
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
                '[{"areaId":"SimpleArea","boDirection":null,"boPercent":null,'
                . '"classes":"class1,class2","blocks":[]}]'
            ),
            array(
                array(
                    array(
                        'areaId' => 'ComplexArea1',
                        'boDirection' => null,
                        'boPercent' => null,
                        'classes' =>
                        array(
                            0 => 'class1',
                            1 => 'class2',
                        ),
                        'subAreas' =>
                        array(
                            array(
                                'areaId' => 'ComplexArea2',
                                'boDirection' => null,
                                'boPercent' => null,
                                'classes' =>
                                array(
                                    0 => 'class1',
                                    1 => 'class3',
                                ),
                                'subAreas' =>
                                array(
                                ),
                                'blocks' =>
                                array(
                                ),
                            ),
                            array(
                                'areaId' => 'ComplexArea3',
                                'boDirection' => null,
                                'boPercent' => null,
                                'classes' =>
                                array(
                                    0 => 'class4',
                                    1 => 'class5',
                                ),
                                'subAreas' =>
                                array(
                                ),
                                'blocks' =>
                                array(
                                ),
                            )
                        ),
                        'blocks' =>
                        array(
                        ),
                    ),
                ),
                '[{"areaId":"ComplexArea1","boDirection":null,"boPercent":null,'
                . '"classes":"class1,class2","blocks":[],'
                . '"areas":[{"areaId":"ComplexArea2","boDirection":null,'
                . '"boPercent":null,"classes":"class1,class3","blocks":[]},'
                . '{"areaId":"ComplexArea3","boDirection":null,'
                . '"boPercent":null,"classes":"class4,class5","blocks":[]}]}]'
            ),
        );
    }
}
