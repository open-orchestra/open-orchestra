<?php

namespace PHPOrchestra\CMSBundle\Test\Form\DataTransformer;

use PHPOrchestra\CMSBundle\Form\DataTransformer\MultilingualTextTransformer;

/**
 * Description of MultilingualTextTransformerTest
 *
 * @author Noël GILAIN <noel.gilain@businessdecision.com>
 */
class MultilingualTextTransformerTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        parent::setUp();
        
        $this->availableLanguages = array('fr' => '', 'en' => '', 'es' => '');
    }
    
    /**
     * @dataProvider getTransformData
     * @param type languages
     * @param type $expectedReturn
     */
    public function testTransform($jsonLanguages, $expectedReturn)
    {
        $transformer = new MultilingualTextTransformer($this->availableLanguages);
        
        $result = $transformer->transform($jsonLanguages);
        
        $this->assertEquals($expectedReturn, $result);
    }
    
    /**
     * Data provider
     */
    public function getTransformData()
    {
        return array(
            array(
                null,
                array(
                    'language_fr' => '',
                    'language_en' => '',
                    'language_es' => ''
                )
            ),
            array(
                'fakejson',
                array(
                    'language_fr' => '',
                    'language_en' => '',
                    'language_es' => ''
                )
            ),
            array(
                '{}',
                array(
                    'language_fr' => '',
                    'language_en' => '',
                    'language_es' => ''
                )
            ),
            array(
                '{"fr":"français", "en":"english", "de":"deutsch"}',
                array(
                    'language_fr' => 'français',
                    'language_en' => 'english',
                    'language_es' => ''
                )
            )
        );
    }
    
    /**
     * @dataProvider getReverseTransformData
     * @param type $formLanguages
     * @param type $expectedReturn
     */
    public function testReverseTransform($formLanguages, $expectedReturn)
    {
        $transformer = new MultilingualTextTransformer($this->availableLanguages);
        
        $result = $transformer->reverseTransform($formLanguages);
        
        $this->assertEquals(json_decode($expectedReturn), json_decode($result));
    }
    
    /**
     * Data provider
     */
    public function getReverseTransformData()
    {
        return array(
            array(null, '[]'),
            array(array(), '[]'),
            array(
                array(
                    'language_fr' => 'français',
                    'fakeKey' => 'fakeValue',
                    'language_en' => 'english'
                ),
                '{"fr":"français", "en":"english"}'
            )
        );
    }
}
