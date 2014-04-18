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

use \PHPOrchestra\CMSBundle\Form\Type\StatusType;

/**
 * Description of StatusTypeTest
 *
 * @author Nicolas BOUQUET <nicolas.bouquet@businessdecision.com>
 */
class StatusTypeTest extends \PHPUnit_Framework_TestCase
{
    public function testGetName()
    {
        $statusType = new StatusType(array());
        
        $this->assertEquals(
            'orchestra_status',
            $statusType->getName()
        );
    }
}
