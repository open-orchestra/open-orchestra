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

use \PHPOrchestra\CMSBundle\Form\Type\TemplateType;

/**
 * Description of TemplateTypeTest
 *
 * @author Nicolas BOUQUET <nicolas.bouquet@businessdecision.com>
 */
class TemplateTypeTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $blocks = array();
        /**
         * A dummy router
         * 
         * @var \Symfony\Component\Routing\Router
         */
        $router = $this->getMockBuilder('\\Symfony\\Component\\Routing\\Router')
                ->disableOriginalConstructor()
                ->getMock();
        
        $router->expects($this->any())
            ->method('generate')
            ->will($this->returnValue('/dummy/url'));
        
        $this->templateType = new TemplateType($router, $blocks);
    }
    
    public function testBuildForm()
    {
        $formBuilderMock =
            $this->getMock('\\Symfony\\Component\\Form\\FormBuilderInterface');
        
        // TODO Improves this test, check some specific added types
        $formBuilderMock
            ->expects($this->exactly(10))
            ->method('add')
            ->will($this->returnSelf());
        
        $this->templateType->buildForm($formBuilderMock, array());
    }
    
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
                        'showDialog' => true,
                        'js' => array(),
                        'objects' => array('areas')
                    )
                )
            );
        
        $this->templateType->setDefaultOptions($resolverMock);
    }*/
    
    /*public function testBuildView()
    {
        $viewMock =
            $this->getMock('\\Symfony\\Component\\Form\\FormView');
        
        $formMock =
            $this->getMock('\\Symfony\\Component\\Form\\FormInterface');
        
        $options = array(
            'showDialog'   => 'value1',
            'js'           => 'value2',
            'objects'      => array('object1', 'object2'),
            'unusedOption' => 'useless'
        );
        
        $this->templateType->buildView($viewMock, $formMock, $options);
        
        $expectedViewVars = $options;
        $expectedViewVars['value'] = null;
        $expectedViewVars['attr'] = array();
        unset($expectedViewVars['unusedOption']);
        
        $this->assertEquals($expectedViewVars, $viewMock->vars);
    }*/

    public function testGetName()
    {
        $this->assertEquals('template', $this->templateType->getName());
    }
}
