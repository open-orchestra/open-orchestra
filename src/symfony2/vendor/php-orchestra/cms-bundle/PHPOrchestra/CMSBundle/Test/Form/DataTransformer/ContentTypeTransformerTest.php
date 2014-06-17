<?php

namespace PHPOrchestra\CMSBundle\Test\Form\DataTransformer;

use \PHPOrchestra\CMSBundle\Form\DataTransformer\ContentTypeTransformer;
use PHPOrchestra\CMSBundle\Test\Mock\TestContentType;

/**
 * Description of ContentTypeTransformerTest
 *
 * @author Noël GILAIN <noel.gilain@businessdecision.com>
 */
class ContentTypeTransformerTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        parent::setUp();
        
        $this->transformer = new ContentTypeTransformer();
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
        
        $this->assertEquals($expectedReturn, $result);
    }
    
    /**
     * Data provider
     */
    public function getTransformData()
    {
        $fields = array(
            'field1' => 'customField1',
            'field2' => 'customField2',
            'field3' => 'customField3',
        );
        
        $result = new TestContentType($fields);
        $result->customField_field1 = 'customField1';
        $result->customField_field2 = 'customField2';
        $result->customField_field3 = 'customField3';
        $result->customFieldsIndex = array('customField_field1', 'customField_field2', 'customField_field3');
        
        return array(
            array(new TestContentType(), new TestContentType()),
            array(new TestContentType($fields), $result)
        );
    }
    
    /**
     * Data provider
     */
    public function getReverseTransformData()
    {
        $fields = array(
            'field1' => 'customField1',
            'field2' => 'customField2',
            'field3' => 'customField3',
        );
        
        
        $datas = new TestContentType(
            $fields,
            array('customField1', 'customField2')
        );
        $datas->customField1 = null;
        $datas->customField2 = 'value2';
        
        $result = clone $datas;
        $result->setFields(json_encode(array('value2')));
        
        
        $datasFull = new TestContentType(
            $fields,
            array('customField1', 'customField2'),
            'newField'
        );
        $datasFull->customField1 = 'value1';
        $datasFull->customField2 = 'value2';
        
        $resultFull = clone $datasFull;
        $resultFull->setFields(
            json_encode(
                array(
                    'value1',
                    'value2',
                    (object) array(
                        'fieldId' => '',
                        'label' => '',
                        'defaultValue' => '',
                        'searchable' => false,
                        'type' => 'newField',
                        'symfonyType' => '',
                        'options' => (object) array()
                    )
                )
            )
        );
        
        
        return array(
            array($datas, $result),
            array($datasFull, $resultFull)
        );
    }
}
