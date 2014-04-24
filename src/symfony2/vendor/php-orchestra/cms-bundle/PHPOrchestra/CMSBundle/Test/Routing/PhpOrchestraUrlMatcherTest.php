<?php

namespace PHPOrchestra\CMSBundle\Test\Routing;

use PHPOrchestra\CMSBundle\Routing\PhpOrchestraUrlMatcher;

/**
 * Tests of PhpOrchestraUrlMatcher
 *
 * @author Nicolas BOUQUET <nicolas.bouquet@businessdecision.com>
 */
class PhpOrchestraUrlMatcherTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Set up a fake database for Route testing
     */
    public function setUp()
    {
        /**
         * Empty context
         * 
         * @var \Symfony\Component\Routing\RequestContext
         */
        $context = $this->getMock('Symfony\\Component\\Routing\\RequestContext');
        
        /**
         * A fake cache system (does not cache or retrieve anything)
         * 
         * @var \PHPOrchestra\CMSBundle\Cache\CacheManagerInterface
         */
        $cacheService = $this->getMock('PHPOrchestra\\CMSBundle\\Cache\\CacheManagerInterface');
        
        /**
         * No other route
         * 
         * @var \Symfony\Component\Routing\RouteCollection
         */
        $routes = $this->getMockBuilder('Symfony\\Component\\Routing\\RouteCollection')
                ->enableProxyingToOriginalMethods()
                ->getMock();
        
        /**
         * Database mock system, using a fake result set
         * 
         * @var \PHPOrchestra\CMSBundle\Test\Mock\Mandango
         */
        $documentService = $this->getMockBuilder('PHPOrchestra\\CMSBundle\\Test\\Mock\\Mandango')
                ->enableProxyingToOriginalMethods()
                ->getMock();
        
        $documentService->setDB(
            array(
                'Model\PHPOrchestraCMSBundle\Node' => array(
                    1 => array(
                        '_id'       => '1',
                        'node_id'   => 1,
                        'parent_id' => 0,
                        'alias'     => '',
                        'node_type' => 'page'
                    ),
                    2 => array(
                        '_id'       => '2',
                        'node_id'   => 2,
                        'parent_id' => 'root',
                        'alias'     => 'test',
                        'node_type' => 'page'
                    ),
                )
            )
        );
        
        /**
         * A document loader using the db mock
         * 
         * @var \PHPOrchestra\CMSBundle\Document\DocumentManager
         */
        $documentManager = $this->getMockBuilder('PHPOrchestra\\CMSBundle\\Document\\DocumentManager')
                ->enableProxyingToOriginalMethods()
                ->setConstructorArgs(array($documentService))
                ->getMock();
        
        $this->matcher = new PhpOrchestraUrlMatcher(
            $routes,
            $context,
            $documentManager,
            $cacheService
        );
    }
    
    /**
     * Destroy initialized objects
     */
    public function tearDown()
    {
        $this->matcher = null;
    }

    /**
     * @dataProvider matchDataProvider
     */
    public function testMatch($route, $controller, $nodeId, $pathinfo)
    {
        $parameters = $this->matcher->match($pathinfo);
        
        $this->assertEquals($route, $parameters['_route']);
        $this->assertEquals($controller, $parameters['_controller']);
        $this->assertEquals($nodeId, $parameters['nodeId']);
    }
    
    public function matchDataProvider()
    {
        return array(
            array(
                'phporchestra_cms_node',
                'PHPOrchestra\\CMSBundle\\Controller\\NodeController::showAction',
                2,
                '/test/'
            ),
        );
    }
}
