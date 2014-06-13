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

use \PHPOrchestra\CMSBundle\Form\Type\OrchestraFieldSelectType;
use \PHPOrchestra\CMSBundle\Test\Mock;

/**
 * Description of OrchestraChoiceTypeTest
 *
 * @author Noël Gilain <noel.gilain@businessdecision.com>
 */
class OrchestraFieldSelectTypeTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->conf = array(
            'orchestra_text' => array('type' => 'text'),
            'orchestra_integer' => array('type' => 'integer'),
            'orchestra_email' => array('type' => 'email')
        );
        
        $this->choices = array(
            'orchestra_text' => 'text',
            'orchestra_integer' => 'integer',
            'orchestra_email' => 'email',
            '' => '---'
        );
        
        $container = $this->getMock('\\Symfony\\Component\\DependencyInjection\\ContainerInterface');
        
        $container->expects($this->once())
            ->method('getParameter')
            ->will($this->returnValue($this->conf));
        
        $this->OrchestraFieldSelectType = new OrchestraFieldSelectType($container);
    }
    
    public function testSetDefaultOptions()
    {
        $resolverMock =
            $this->getMock('\\Symfony\\Component\\OptionsResolver\\OptionsResolverInterface');
        
        $resolverMock
            ->expects($this->once())
            ->method('setDefaults')
            ->with($this->equalTo(array('choices' => $this->choices)));
        
        $this->OrchestraFieldSelectType->setDefaultOptions($resolverMock);
    }
    
    public function testGetParent()
    {
        $this->assertEquals('choice', $this->OrchestraFieldSelectType->getParent());
    }

    public function testGetName()
    {
        $this->assertEquals('orchestra_fieldSelect', $this->OrchestraFieldSelectType->getName());
    }
}
