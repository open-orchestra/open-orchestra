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

use \PHPOrchestra\CMSBundle\Form\Type\TemplateChoiceType;
use \PHPOrchestra\CMSBundle\Test\Mock;

/**
 * Description of TemplateChoiceTypeTest
 *
 * @author Nicolas BOUQUET <nicolas.bouquet@businessdecision.com>
 */
class TemplateChoiceTypeTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->templates = array(
            array('_id' => 'abcd', 'name' => 'Dummy Template 1'),
            array('_id' => 'abce', 'name' => 'Dummy Template 2'),
            array('_id' => 'abcf', 'name' => 'Dummy Template 3'),
            array('_id' => 'abcg', 'name' => 'Dummy Template 4'),
            array('_id' => 'abch', 'name' => 'Dummy Template 5'),
        );
        
        /**
         * A document loader using the db mock
         * 
         * @var \PHPOrchestra\CMSBundle\Document\DocumentManager
         */
        $documentManager = $this->getMockBuilder('PHPOrchestra\\CMSBundle\\Document\\DocumentManager')
                ->disableOriginalConstructor()
                ->getMock();
        
        $documentManager->expects($this->any())
            ->method('getTemplatesInLastVersion')
            ->will($this->returnValue($this->templates));
        
        $this->templateChoiceType = new TemplateChoiceType($documentManager);
    }
    
    /*public function testSetDefaultOptions()
    {
        $choices = array('' => '--------');
        foreach ($this->templates as $template) {
            $choices[$template['_id']] = $template['name'];
        }
        
        $resolverMock =
            $this->getMock('\\Symfony\\Component\\OptionsResolver\\OptionsResolverInterface');
        
        $resolverMock
            ->expects($this->once())
            ->method('setDefaults')
            ->with($this->equalTo(array('choices' => $choices)));
        
        $this->templateChoiceType->setDefaultOptions($resolverMock);
    }*/
    
    public function testGetParent()
    {
        $this->assertEquals('choice', $this->templateChoiceType->getParent());
    }

    public function testGetName()
    {
        $this->assertEquals('orchestra_template_choice', $this->templateChoiceType->getName());
    }
}
