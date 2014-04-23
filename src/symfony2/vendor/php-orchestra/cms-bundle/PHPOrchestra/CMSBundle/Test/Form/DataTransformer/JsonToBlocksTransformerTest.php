<?php

namespace PHPOrchestra\CMSBundle\Test\Form\DataTransformer;

use \PHPOrchestra\CMSBundle\Form\DataTransformer\JsonToBlocksTransformer;
use \PHPOrchestra\CMSBundle\Test\Mock;

/**
 * Description of JsonToBlocksTransformerTest
 *
 * @author nbouquet
 */
class JsonToBlocksTransformerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Transformer object to test
     * 
     * @var \PHPOrchestra\CMSBundle\Form\DataTransformer\JsonToBlocksTransformer
     */
    protected $transformer;
    
    /**
     * Initializes the transformer to be tested
     */
    public function setUp()
    {
        parent::setUp();
        
        /**
         * Database mock system, using a fake result set
         * 
         * @var \PHPOrchestra\CMSBundle\Test\Mock\Mandango
         */
        $this->documentService = $this->getMockBuilder(
            'PHPOrchestra\\CMSBundle\\Test\\Mock\\Mandango'
        )
            ->enableProxyingToOriginalMethods()
            ->getMock();
        
        /**
         * A document loader using the db mock
         * 
         * @var \PHPOrchestra\CMSBundle\Document\DocumentLoader
         */
        $this->documentLoader = $this->getMockBuilder(
            'PHPOrchestra\\CMSBundle\\Document\\DocumentLoader'
        )
            ->enableProxyingToOriginalMethods()
            ->setConstructorArgs(array($this->documentService))
            ->getMock();
        
        $this->transformer = new JsonToBlocksTransformer($this->documentLoader);
    }
    
    /**
     * Test Blocks to Json transformation
     * 
     * @dataProvider jsonToBlocksData
     * @param type $expectedJson
     * @param type $blocks
     */
    public function testTransform($blocks, $expectedJson)
    {
        if (isset($blocks)) {
            /**
             * @var \Mandango\Group\EmbeddedGroup
             */
            $blockGroup = $this->getMockBuilder('\\Mandango\\Group\\EmbeddedGroup')
                ->setConstructorArgs(
                    array('\\PHPOrchestra\\CMSBundle\\Test\\Mock\\MandangoDocument')
                )
                ->getMock();
        
            $embeddedBlocks = array();
            foreach ($blocks as $block) {
                $embeddedBlock = new Mock\MandangoDocument($this->documentService);
                $embeddedBlock->setComponent($block['component']);
                $embeddedBlock->setAttributes($block['attributes']);

                $embeddedBlocks[] = $embeddedBlock;
            }

            $blockGroup->expects($this->once())
                ->method('getSaved')
                ->will($this->returnValue($embeddedBlocks));
        } else {
            $blockGroup = null;
        }
        
        $transformedJson = $this->transformer->transform($blockGroup);
        
        $this->assertJsonStringEqualsJsonString(
            $expectedJson,
            $transformedJson
        );
        
    }
    
    /**
     * Test Json to Blocks transformation
     * 
     * @dataProvider jsonToBlocksData
     * @param type $expectedJson
     * @param type $blocks
     */
    public function testReverseTransform($expectedBlocks, $json)
    {
        $transformedBlocks = $this->transformer->reverseTransform($json);
        
        $i = 0;
        foreach ($transformedBlocks as $block) {
            $this->assertEquals(
                $expectedBlocks[$i]['component'],
                $block->getComponent()
            );
            $this->assertEquals(
                $expectedBlocks[$i]['attributes'],
                $block->getAttributes()
            );
            $i++;
        }
        
        $this->assertCount(count($expectedBlocks), $transformedBlocks);
    }
    
    /**
     * Data provider
     */
    public function jsonToBlocksData()
    {
        // Array of test data
        return array(
            // Array of parameters
            array(
                // Array of Blocks
                array(
                    // Block definition
                    array(
                        'component' => 'MyComponent',
                        'attributes' => array(
                            'attr1' => 'value1',
                            'attr2' => 'value2'
                        )
                    )
                ),
                // Json
                '[{"component":"MyComponent","attributes":{"attr1":"value1","attr2":"value2"}}]'
            ),
            // Array of parameters
            array(
                // Array of Blocks
                null,
                // Json
                '[]'
            )
        );
    }
}
