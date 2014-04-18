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

use \PHPOrchestra\CMSBundle\Form\Type\OrchestraChoiceType;
use \PHPOrchestra\CMSBundle\Test\Mock;

/**
 * Description of OrchestraChoiceTypeTest
 *
 * @author Nicolas BOUQUET <nicolas.bouquet@businessdecision.com>
 */
class OrchestraChoiceTypeTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        
        $this->choices = array(
            'key1' => 'value1',
            'key2' => 'value2',
            'key3' => 'value3',
        );
        
        $this->orchestraChoiceType = new OrchestraChoiceType($this->choices);
    }
    
    public function testSetDefaultOptions()
    {
        $resolverMock =
            $this->getMock('\\Symfony\\Component\\OptionsResolver\\OptionsResolverInterface');
        
        $resolverMock
            ->expects($this->once())
            ->method('setDefaults')
            ->with($this->equalTo(array('choices' => $this->choices)));
        
        $this->orchestraChoiceType->setDefaultOptions($resolverMock);
    }
    
    public function testGetParent()
    {
        $this->assertEquals('choice', $this->orchestraChoiceType->getParent());
    }

    public function testGetName()
    {
        $this->assertEquals('orchestra_choice', $this->orchestraChoiceType->getName());
    }
}
