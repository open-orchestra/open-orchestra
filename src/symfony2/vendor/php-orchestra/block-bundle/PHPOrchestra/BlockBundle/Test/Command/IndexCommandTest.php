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
    
namespace PHPOrchestra\BlockBundle\Test\Command;

use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use PHPOrchestra\BlockBundle\Command\IndexCommand;

/**
 * Unit test of IndexCommand
 * 
 * @author Benjamin Fouché <benjamin.fouche@businessdecsion.com>
 *
 */
class IndexCommandTest extends \PHPUnit_Framework_TestCase
{

    protected $mandango = null;
    
    protected $kernel = null;
    
    protected $container = null;
    
    public function setUp()
    {
        $this->mandango = $this->getMock('PHPOrchestra\\CMSBundle\\Test\\Mock\\Mandango');
        
        $repository = $this->getMock(
            'PHPOrchestra\\CMSBundle\\Test\\Mock\\MandangoDocumentRepository',
            array('getAll'),
            array($this->mandango)
        );
        
        $this->container = $this->getMock('\\Symfony\\Component\\DependencyInjection\\Container');
        
        $this->kernel = $this->getMock(
            '\\Symfony\\Component\\HttpKernel\\Kernel',
            array(),
            array('dev', 'dev'),
            '',
            true,
            false,
            false
        );
        
        $trans = $this->getMock('\\Symfony\\Component\\Translation\\Translator', array(), array('en'));
        
        $this->mandango->expects($this->once())->method('getRepository')->will($this->returnValue($repository));
        $this->container->expects($this->at(0))->method('get')->will($this->returnValue($this->mandango));
        $this->container->expects($this->at(1))->method('get')->will($this->returnValue($trans));
        $this->kernel->expects($this->once())->method('getContainer')->will($this->returnValue($this->container));
        
    }
    
    
    /**
     * Execute IndexCommand
     */
    public function testExecute()
    {
        $application = new Application($this->kernel);
        $application->add(new IndexCommand());
        
        $command = $application->find('solr:index');
        $commandTest = new CommandTester($command);
        $commandTest->execute(array('command' => $command->getName()));

        $this->assertEquals("", $commandTest->getDisplay());
    }
}
