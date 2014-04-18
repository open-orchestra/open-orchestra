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

use \PHPOrchestra\CMSBundle\Form\Type\LanguageType;

/**
 * Description of LanguageTypeTest
 *
 * @author Nicolas BOUQUET <nicolas.bouquet@businessdecision.com>
 */
class LanguageTypeTest extends \PHPUnit_Framework_TestCase
{
    public function testGetName()
    {
        $languageType = new LanguageType(array());
        
        $this->assertEquals(
            'orchestra_language',
            $languageType->getName()
        );
    }
}
