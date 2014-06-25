<?php

namespace PHPOrchestra\CMSBundle\Test\Form\DataTransformer;

use \PHPOrchestra\CMSBundle\Form\DataTransformer\CustomFieldTransformer;

/**
 * Description of CustomFieldTransformerTest
 *
 * @author Noël GILAIN <noel.gilain@businessdecision.com>
 */
class CustomFieldTransformerTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        parent::setUp();
        
        $this->transformer = new CustomFieldTransformer();
    }
    
    /**
     * @dataProvider getTransformData
     * @param type $input
     * @param type $output
     */
    public function testTransform($input, $output)
    {
        $result = $this->transformer->transform($input);
        
        $this->assertEquals($output, $result);
    }
    
    /**
     * @dataProvider getReverseTransformData
     * @param type $input
     * @param type $output
     */
    public function testReverseTransform($input, $output)
    {
        $result = $this->transformer->reverseTransform($input);
        
        $this->assertEquals($output, $result);
    }
    
    /**
     * Data provider
     */
    public function getTransformData()
    {
        return array(
            array(
                (object) array(),
                (object) array('removeField' => false)
            ),
            array(
                (object) array(
                    'options' => array(
                        'name1' => 'params1',
                        'name2' => 'params2',
                        'name3' => 'params3',
                    )
                ),
                (object) array(
                    'removeField' => false,
                    'option_name1' => 'params1',
                    'option_name2' => 'params2',
                    'option_name3' => 'params3',
                )
            ),
        );
    }
        
    /**
     * Data provider
     */
    public function getReverseTransformData()
    {
        return array(
            array(
                (object) array(
                    'removeField' => true
                ),
                (object) array(
                    'removeField' => true
                )
            ),
            array(
                (object) array('removeField' => false),
                (object) array('removeField' => false),
            ),
            array(
                (object) array(
                    'fakekey' => 'fakevalue',
                    'option_name1' => 'param1',
                    'option_name2' => 'param2',
                    'option_name3' => 'param3',
                ),
                (object) array(
                    'fakekey' => 'fakevalue',
                    'options' => array(
                        'name1' => 'param1',
                        'name2' => 'param2',
                        'name3' => 'param3',
                    ),
                )
            ),
        );
    }
}
