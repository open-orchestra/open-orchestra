<?php

namespace PHPOrchestra\CMSBundle\Test\Form\DataTransformer;

use \PHPOrchestra\CMSBundle\Form\DataTransformer\ContentTypeFieldsTransformer;

/**
 * Description of ContentTypeTransformerTest
 *
 * @author Noël GILAIN <noel.gilain@businessdecision.com>
 */
class ContentTypeFieldsTransformerTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        parent::setUp();
        
        $this->transformer = new ContentTypeFieldsTransformer();
    }
    
    /**
     * @dataProvider getTransformData
     * @param type $contentType
     * @param type $expectedReturn
     */
    public function testTransform($contentType, $expectedReturn)
    {
        $result = $this->transformer->transform($contentType);
        
        $this->assertEquals($expectedReturn, $result);
    }
    
    /**
     * @dataProvider getReverseTransformData
     * @param type $datas
     * @param type $expectedReturn
     */
    public function testReverseTransform($datas, $expectedReturn)
    {
        $result = $this->transformer->reverseTransform($datas);
        
        $this->assertEquals(json_decode($expectedReturn), json_decode($result));
    }
    
    /**
     * Data provider
     */
    public function getTransformData()
    {
        $jsonFields = '[{"label" : "someValue1"}, {"label" : "someValue2"}, {"label" : "someValue3"}]';
        
        return array(
            array('', array('jsonFields' => '')),
            array(
                $jsonFields,
                array(
                    'jsonFields' => $jsonFields,
                    'customField_0' => (object) array('label' => 'someValue1'),
                    'customField_1' => (object) array('label' => 'someValue2'),
                    'customField_2' => (object) array('label' => 'someValue3')
                ))
            );
    }
    
    /**
     * Data provider
     */
    public function getReverseTransformData()
    {
        $fields = array(
            'otherKey' => 'unusedValue',
            'customField_field1' => (object)array('removeField' => false, 'key1' => 'value1'),
            'customField_field2' => (object)array('removeField' => true, 'key2' => 'value2'),
            'customField_field3' => (object)array('removeField' => false, 'key3' => 'value3')
        );
        
        /************ TEST DATAS  *************************/
        
        return array(
            array(array(), '[]'),
            array(
                $fields,
                '[
                    {"removeField" : false, "key1": "value1"},
                    {"removeField" : false, "key3": "value3"}
                 ]'
            )
        );
    }
}
