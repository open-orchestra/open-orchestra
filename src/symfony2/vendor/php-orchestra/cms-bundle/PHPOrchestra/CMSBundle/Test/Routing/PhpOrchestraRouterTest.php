<?php

namespace PHPOrchestra\CMSBundle\Test\Routing;

use PHPOrchestra\CMSBundle\Routing\PhpOrchestraRouter;
use Symfony\Component\Routing\RouteCollection;

/**
 * Tests of PhpOrchestraUrlRouter
 *
 * @author Noel GILAIN <noel.gilain@businessdecision.com>
 */
class PhpOrchestraRouterTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $container = $this->getMock('\\Symfony\\Component\\DependencyInjection\\ContainerInterface');
        
        $mockRoutingLoader = $this->getMockBuilder('\\Symfony\\Bundle\\FrameworkBundle\\Routing\\DelegatingLoader')
            ->disableOriginalConstructor()
            ->getMock();
        
        $mockRoutingLoader->expects($this->any())
            ->method('load')
            ->will($this->returnValue(new RouteCollection()));
        
        $container->expects($this->at(1)) // 'phporchestra_cms.documentmanager'
            ->method('get')
            ->will($this->returnValue(null));
        
        $container->expects($this->at(2)) // 'routing.loader'
            ->method('get')
            ->will($this->returnValue($mockRoutingLoader));
        
        $this->router = new PhpOrchestraRouter(
            $container,
            null,
            array(
                'generator_class' => 'PHPOrchestra\CMSBundle\Routing\PhpOrchestraUrlGenerator',
                'generator_base_class' => 'PHPOrchestra\CMSBundle\Routing\PhpOrchestraUrlGenerator',
                'matcher_class' => 'PHPOrchestra\CMSBundle\Routing\PhpOrchestraUrlMatcher',
                'matcher_base_class' => 'PHPOrchestra\CMSBundle\Routing\PhpOrchestraUrlMatcher'
            )
        );
    }
    
    public function testGetMatcher()
    {
        $this->assertInstanceOf(
            'PHPOrchestra\\CMSBundle\\Routing\\PhpOrchestraUrlMatcher',
            $this->router->getMatcher()
        );
    }
    
    public function testGetGenerator()
    {
        $this->assertInstanceOf(
            'PHPOrchestra\\CMSBundle\\Routing\\PhpOrchestraUrlGenerator',
            $this->router->getGenerator()
        );
    }
}
