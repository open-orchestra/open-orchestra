<?php

/*
 * Business & Decision - Commercial License
 *
 * Copyright 2014 Business & Decision.
 *
 * All rights reserved. You CANNOT use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell this Software or any parts of this
 * Software, without the written authorization of Business & Decision.
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * See LICENSE.txt file for the full LICENSE text.
 */

namespace PHPOrchestra\CMSBundle\Test\Form\Type;

use \PHPOrchestra\CMSBundle\Form\Type\BlockChoiceType;
use \PHPOrchestra\CMSBundle\Test\Mock;

/**
 * Description of BlockChoiceTypeTest
 *
 * @author Nicolas BOUQUET <nicolas.bouquet@businessdecision.com>
 */
class BlockChoiceTypeTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        
        /**
         * Database mock system, using a fake result set
         * 
         * @var \PHPOrchestra\CMSBundle\Test\Mock\Mandango
         */
/*        $documentService = $this->getMockBuilder('PHPOrchestra\\CMSBundle\\Test\\Mock\\Mandango')
                ->enableProxyingToOriginalMethods()
                ->getMock();
        
        $blocks = array();
        for ($i = 0; $i < 4; $i++) {
            $block = new Mock\MandangoDocument($documentService);
            $block->setComponent('DummyComponent' . $i);
            $blocks[] = $block;
        }
        
        $documentService->setDB(
            array(
                'Model\PHPOrchestraCMSBundle\Node' => array(
                    1 => array(
                        '_id'       => '1',
                        'node_id'   => 1,
                        'parent_id' => 0,
                        'alias'     => '',
                        'node_type' => 'page',
                        'blocks'    => $blocks
                    ),
                )
            )
        );*/
        
        /**
         * A document loader using the db mock
         * 
         * @var \PHPOrchestra\CMSBundle\Document\DocumentManager
         */
      /*  $documentManager = $this->getMockBuilder('PHPOrchestra\\CMSBundle\\Document\\DocumentManager')
                ->enableProxyingToOriginalMethods()
                ->setConstructorArgs(array($documentService))
                ->getMock();
        
        $filters = array(
            'key1' => array('action' => 'DummyComponent3'),
            'key2' => array('action' => 'DummyComponent1'),
        );
        
        $this->blockChoiceType = new BlockChoiceType($documentManager, 1, $filters);*/
    }
    
    public function testSetDefaultOptions()
    {
    /*    $resolverMock =
            $this->getMock('\\Symfony\\Component\\OptionsResolver\\OptionsResolverInterface');
        
        $resolverMock
            ->expects($this->once())
            ->method('setDefaults')
            ->with(
                $this->equalTo(
                    array(
                        // TODO Improve choices, first entry should also have a
                        // numeric index
                        'choices' => array(
                            '' => '--------',
                            1 => 'key2',
                            2 => 'key1'
                        )
                    )
                )
            );
        
        $this->blockChoiceType->setDefaultOptions($resolverMock);*/
    }
    
    public function testGetParent()
    {
       // $this->assertEquals('choice', $this->blockChoiceType->getParent());
    }

    public function testGetName()
    {
       // $this->assertEquals('orchestra_block_choice', $this->blockChoiceType->getName());
    }
}
