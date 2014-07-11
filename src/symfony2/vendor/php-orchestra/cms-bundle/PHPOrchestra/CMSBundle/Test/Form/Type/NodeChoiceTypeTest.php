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

use \PHPOrchestra\CMSBundle\Form\Type\NodeChoiceType;
use \PHPOrchestra\CMSBundle\Test\Mock;

/**
 * Description of NodeChoiceTypeTest
 *
 * @author Nicolas BOUQUET <nicolas.bouquet@businessdecision.com>
 */
class NodeChoiceTypeTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->nodes = array(
            array('_id' => 'abcd', 'name' => 'Dummy Node 1'),
            array('_id' => 'abce', 'name' => 'Dummy Node 2'),
            array('_id' => 'abcf', 'name' => 'Dummy Node 3'),
            array('_id' => 'abcg', 'name' => 'Dummy Node 4'),
            array('_id' => 'abch', 'name' => 'Dummy Node 5'),
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
            ->method('getNodesInLastVersion')
            ->will($this->returnValue($this->nodes));
        
        $this->nodeChoiceType = new NodeChoiceType($documentManager);
    }
    
    /*public function testSetDefaultOptions()
    {
        $choices = array('' => '--------');
        foreach ($this->nodes as $node) {
            $choices[$node['_id']] = $node['name'];
        }
        
        $resolverMock =
            $this->getMock('\\Symfony\\Component\\OptionsResolver\\OptionsResolverInterface');
        
        $resolverMock
            ->expects($this->once())
            ->method('setDefaults')
            ->with($this->equalTo(array('choices' => $choices)));
        
        $this->nodeChoiceType->setDefaultOptions($resolverMock);
    }*/
    
    public function testGetParent()
    {
        $this->assertEquals('choice', $this->nodeChoiceType->getParent());
    }

    public function testGetName()
    {
        $this->assertEquals('orchestra_node_choice', $this->nodeChoiceType->getName());
    }
}
