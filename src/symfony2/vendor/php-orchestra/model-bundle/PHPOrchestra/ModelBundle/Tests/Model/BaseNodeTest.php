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

namespace PHPOrchestra\ModelBundle\Tests\Model;

require_once __DIR__.'/../../../../../../../app/AppKernel.php';

/**
 * Description of BaseNodeTest
 *
 * @author Nicolas BOUQUET <nicolas.bouquet@businessdecision.com>
 */
class BaseNodeTest extends \PHPUnit_Framework_TestCase
{
    /*
    public function testNodeCreation()
    {   $kernel = new \AppKernel('dev', true);
        $kernel->boot();

        $container = $kernel->getContainer();
        
        $node = new \PHPOrchestraModel\MongoBundle\Document\Node;
        $node
            ->setName('Test')
            ->setAlias('test')
            ->setPath('/1/2/3')
            ->setStatus('published');
        
        $dm = $container->get('doctrine_mongodb')->getManager();
        $dm->persist($node);
        $dm->flush();
    }
     */
}
