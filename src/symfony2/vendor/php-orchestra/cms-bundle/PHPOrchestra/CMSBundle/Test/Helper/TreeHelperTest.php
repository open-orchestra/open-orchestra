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

namespace PHPOrchestra\CMSBundle\Test\Helper;

use \PHPOrchestra\CMSBundle\Helper\TreeHelper;

/**
 * Unit tests of NodesHelper
 *
 * @author Nicolas BOUQUET <nicolas.bouquet@businessdecision.com>
 */
class NodesHelperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider createTreeData
     * @param array $expectedResult
     * @param array $nodes
     */
    public function testCreateTree($expectedResult, $nodes)
    {
        /*$result = TreeHelper::createTree($nodes);
        $this->assertEquals($expectedResult, $result);*/
    }
    
    public function createTreeData()
    {
        return array(
            array(
                array(
                    array(
                        'id' => 'root',
                        'class' => '',
                        'text' => 'Home page',
                        'sublinks' => array(
                            array(
                                'id' => '2',
                                'class' => 'deleted',
                                'text' => 'Home child'
                            )
                        )
                    )
                ),
                array(
                    array(
                        '_id'       => 'root',
                        'parentId'  => '0',
                        'name'      => 'Home page',
                        'deleted'   => false
                    ),
                    array(
                        '_id'       => '2',
                        'parentId'  => 'root',
                        'name'      => 'Home child',
                        'deleted'   => true
                    ),
                )
            )
        );
    }
}
