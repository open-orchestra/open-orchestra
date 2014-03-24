<?php

namespace PHPOrchestra\CMSBundle\Tests\Controller;

use PHPOrchestra\CMSBundle\Twig\PhpOrchestraExtension;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel;
use Symfony\Component\HttpKernel\Fragment\FragmentHandler;
use Symfony\Component\HttpKernel\Controller\ControllerReference;

class PhpOrchestraExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function testRenderBlock()
    {
        $container = $this->getMock('Symfony\Component\DependencyInjection\ContainerInterface');
        $kernel = $this->getMock('Symfony\Component\HttpKernel\KernelInterface');
        $fragmentHandler = $this->getMock('Symfony\Component\HttpKernel\Fragment\FragmentHandler');

        $kernel
            ->expects($this->once())
            ->method('getBundle')
            ->will($this->returnValue('PHPOrchestraCMSBundle'));
        
        $container
            ->expects($this->at(0))
            ->method('get')
            ->with('kernel')
            ->will($this->returnValue($kernel));

        $container
            ->expects($this->at(1))
            ->method('get')
            ->with('fragment.handler')
            ->will($this->returnValue($fragmentHandler));
       
        $fragmentHandler
            ->expects($this->once())
            ->method('render')
            ->will($this->returnValue('someHtml'));
        
        $phpOrchestraExtension = new PhpOrchestraExtension($container);
        
        $controllerReference = new ControllerReference('PHPOrchestraCMSBundle:Block:fake');
        $this->assertFalse($phpOrchestraExtension->renderBlock($controllerReference));
    }
    
    
//    public function testIs_callable()
//    {
//    }
}
