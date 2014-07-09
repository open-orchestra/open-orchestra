<?php

namespace PHPOrchestra\CMSBundle\Test\Form\DataTransformer;

use \PHPOrchestra\CMSBundle\Form\DataTransformer\ContentAttributesTransformer;
use PHPOrchestra\CMSBundle\Test\Mock\TestAttribute;

/**
 * Description of ContentAttributesTransformerTest
 *
 * @author Noël GILAIN <noel.gilain@businessdecision.com>
 */
class ContentAttributesTransformerTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        parent::setUp();
        
        $this->documentManager = $this->getMockBuilder('PHPOrchestra\\CMSBundle\\Document\\DocumentManager')
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->documentManager
            ->expects($this->any())
            ->method('createDocument')
            ->will($this->returnCallback(array($this, 'createAttribute')));
    }
    
    public function createAttribute()
    {
        return new TestAttribute();
    }
    
    /**
     * @dataProvider getTransformData
     * @param type $fieldStructure
     * @param type $attributes
     * @param type $expectedReturn
     */
    public function testTransform($fieldStructure, $attributes, $expectedReturn)
    {
        $transformer = new ContentAttributesTransformer($this->documentManager, $fieldStructure);
        
        $result = $transformer->transform($attributes);
        
        $this->assertEquals($expectedReturn, $result);
    }
    
    /**
     * @dataProvider getReverseTransformData
     * @param type $fieldStructure
     * @param type $attributes
     * @param type $expectedReturn
     */
    public function testReverseTransform($fieldStructure, $attributes, $expectedReturn)
    {
        $transformer = new ContentAttributesTransformer($this->documentManager, $fieldStructure);
        
        $result = $transformer->reverseTransform($attributes);
        
        $this->assertEquals($expectedReturn, $result);
    }
    
    /**
     * Data provider
     */
    public function getTransformData()
    {
        return array(
        
            array(
                array(),
                (object) array(
                    'attribute1' => new TestAttribute('name1', 'value1'),
                    'attribute2' => new TestAttribute('name2', 'value2')
                ),
                (object) array(
                    'attribute1' => new TestAttribute('name1', 'value1'),
                    'attribute2' => new TestAttribute('name2', 'value2'),
                    'name1' => 'value1',
                    'name2' => 'value2'
                )
            ),
        
            array(
                array(
                    (object) array(
                        'fieldId' => 'field1',
                        'defaultValue' => 'defaultValue1'
                    )
                ),
                (object) array(),
                (object) array(
                    'field1' => 'defaultValue1'
                )
            ),
        
            array(
                array(
                    (object) array(
                        'fieldId' => 'field1',
                        'defaultValue' => 'defaultValue1'
                    ),
                    (object) array(
                        'fieldId' => 'field2',
                        'defaultValue' => 'defaultValue2'
                    )
                ),
                (object) array(
                    'attribute1' => new TestAttribute('name1', 'value1'),
                    'attribute2' => new TestAttribute('name2', 'value2'),
                    'attribute3' => new TestAttribute('field1', 'overrideValue1')
                ),
                (object) array(
                    'attribute1' => new TestAttribute('name1', 'value1'),
                    'attribute2' => new TestAttribute('name2', 'value2'),
                    'attribute3' => new TestAttribute('field1', 'overrideValue1'),
                    'field1' => 'overrideValue1',
                    'field2' => 'defaultValue2',
                    'name1' => 'value1',
                    'name2' => 'value2'
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
                array(),
                (object) array(
                    'field1' => 'formValue1',
                    'field2' => 'formValue2'
                ),
                array()
            ),
        
            array(
                array(
                    (object) array(
                        'fieldId' => 'field1',
                        'defaultValue' => 'defaultValue1'
                    )
                ),
                (object) array(),
                array()
            ),
        
            array(
                array(
                    (object) array(
                        'fieldId' => 'field1',
                        'defaultValue' => 'defaultValue1'
                    ),
                    (object) array(
                        'fieldId' => 'field2',
                        'defaultValue' => 'defaultValue2'
                    )
                ),
                (object) array(
                    'field1' => 'formValue1',
                    'field2' => 'formValue2'
                ),
                array(
                    new TestAttribute('field1', 'formValue1'),
                    new TestAttribute('field2', 'formValue2')
                )
            )
            );
    }
}
