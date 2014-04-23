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

use \PHPOrchestra\CMSBundle\Helper\TemplateHelper;

/**
 * Unit tests of TemplateHelper
 *
 * @author Nicolas BOUQUET <nicolas.bouquet@businessdecision.com>
 */
class TemplateHelperTest extends \PHPUnit_Framework_TestCase
{
    public function testFormatTemplate()
    {
        // TODO, provide real data
        $templateMock = $this->getMockBuilder('\\Model\\PHPOrchestraCMSBundle\\Template')
            ->disableOriginalConstructor()
            ->getMock();
        
        /**
         * Database mock system, using a fake result set
         * 
         * @var \PHPOrchestra\CMSBundle\Test\Mock\Mandango
         */
        $documentService = $this->getMockBuilder('\\PHPOrchestra\\CMSBundle\\Test\\Mock\\Mandango')
                ->enableProxyingToOriginalMethods()
                ->getMock();
        
        /**
         * A document loader using the db mock
         * 
         * @var \PHPOrchestra\CMSBundle\Document\DocumentLoader
         */
        $documentLoader = $this->getMockBuilder('\\PHPOrchestra\\CMSBundle\\Document\\DocumentLoader')
                ->enableProxyingToOriginalMethods()
                ->setConstructorArgs(array($documentService))
                ->getMock();
        
        $result = TemplateHelper::formatTemplate(
            $templateMock,
            $documentLoader
        );
        
        $this->assertEquals(
            array('areas' => '[]', 'blocks' => '[]'),
            $result
        );
    }
}
