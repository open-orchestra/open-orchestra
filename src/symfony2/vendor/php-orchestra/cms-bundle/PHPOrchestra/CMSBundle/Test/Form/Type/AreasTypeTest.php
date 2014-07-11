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

use \PHPOrchestra\CMSBundle\Form\Type\AreasType;

/**
 * Description of AreasTypeTest
 *
 * @author Nicolas BOUQUET <nicolas.bouquet@businessdecision.com>
 */
class AreasTypeTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->areasType = new AreasType();
    }
    
    /*public function testBuildForm()
    {
        $formBuilderMock =
            $this->getMock('\\Symfony\\Component\\Form\\FormBuilderInterface');
        
        $formBuilderMock
            ->expects($this->once())
            ->method('addModelTransformer')
            ->with($this->isInstanceOf('\\PHPOrchestra\\CMSBundle\\Form\\DataTransformer\\JsonToAreasTransformer'));
        
        $this->areasType->buildForm($formBuilderMock, array());
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
        
        $this->areasType->setDefaultOptions($resolverMock);
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
        
        $this->areasType->buildView($viewMock, $formMock, $options);
        
        $expectedViewVars = $options;
        $expectedViewVars['value'] = null;
        $expectedViewVars['attr'] = array();
        unset($expectedViewVars['unusedOption']);
        
        $this->assertEquals($expectedViewVars, $viewMock->vars);
    }*/
    
    public function testGetParent()
    {
        $this->assertEquals('hidden', $this->areasType->getParent());
    }

    public function testGetName()
    {
        $this->assertEquals('orchestra_areas', $this->areasType->getName());
    }
}
