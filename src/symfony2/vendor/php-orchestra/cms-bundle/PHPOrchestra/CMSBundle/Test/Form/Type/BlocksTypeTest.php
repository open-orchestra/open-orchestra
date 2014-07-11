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

use \PHPOrchestra\CMSBundle\Form\Type\BlocksType;

/**
 * Description of BlocksTypeTest
 *
 * @author Nicolas BOUQUET <nicolas.bouquet@businessdecision.com>
 */
class BlocksTypeTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        /**
         * A dummy document loader
         * 
         * @var \PHPOrchestra\CMSBundle\Document\DocumentManager
         */
        $documentManager = $this->getMockBuilder('PHPOrchestra\\CMSBundle\\Document\\DocumentManager')
                ->disableOriginalConstructor()
                ->getMock();
        
        $this->blocksType = new BlocksType($documentManager);
    }
    
    /*public function testBuildForm()
    {
        $formBuilderMock =
            $this->getMock('\\Symfony\\Component\\Form\\FormBuilderInterface');
        
        $formBuilderMock
            ->expects($this->once())
            ->method('addModelTransformer')
            ->with($this->isInstanceOf('\\PHPOrchestra\\CMSBundle\\Form\\DataTransformer\\JsonToBlocksTransformer'));
        
        $this->blocksType->buildForm($formBuilderMock, array());
    }*/
    
    /*public function testSetDefaultOptions()
    {
        $resolverMock =
            $this->getMock('\\Symfony\\Component\\OptionsResolver\\OptionsResolverInterface');
        
        $resolverMock
            ->expects($this->once())
            ->method('setDefaults')
            ->with(
                $this->equalTo(
                    array(
                        'dialogPath' => '',
                        'js' => array(),
                        'objects' => array(),
                        'attr' => array('class' => 'not-mapped')
                    )
                )
            );
        
        $this->blocksType->setDefaultOptions($resolverMock);
    }*/
    
    /*public function testBuildView()
    {
        $viewMock =
            $this->getMock('\\Symfony\\Component\\Form\\FormView');
        
        $formMock =
            $this->getMock('\\Symfony\\Component\\Form\\FormInterface');
        
        $options = array(
            'dialogPath'   => 'value1',
            'js'           => 'value2',
            'objects'      => array('object1', 'object2'),
            'unusedOption' => 'useless'
        );
        
        $this->blocksType->buildView($viewMock, $formMock, $options);
        
        $expectedViewVars = $options;
        $expectedViewVars['value'] = null;
        $expectedViewVars['attr'] = array();
        unset($expectedViewVars['unusedOption']);
        
        $this->assertEquals($expectedViewVars, $viewMock->vars);
    }*/
    
    public function testGetParent()
    {
        $this->assertEquals('hidden', $this->blocksType->getParent());
    }

    public function testGetName()
    {
        $this->assertEquals('orchestra_blocks', $this->blocksType->getName());
    }
}
