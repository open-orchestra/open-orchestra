<?php

namespace PHPOrchestra\CMSBundle\Test\Routing;

use PHPOrchestra\CMSBundle\Routing\PhpOrchestraUrlMatcher;
use Symfony\Component\Routing\RouteCollection;

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
        $cacheService->expects($this->any())
            ->method('get')
            ->will($this->returnCallback(array($this, 'getFromCacheCallback')));
        $this->cache[PhpOrchestraUrlMatcher::PATH_PREFIX . '/test-cache'] = array(
            "_route" => "phporchestra_cms_module",
            "_controller" => 'PHPOrchestra\CMSBundle\Controller\NodeController::showAction',
            "nodeId" => "3",
            "module_parameters" => serialize(array('param1'))
        );
            
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
                    3 => array(
                        '_id'       => '3',
                        'node_id'   => 3,
                        'parent_id' => '2',
                        'alias'     => 'module',
                        'node_type' => 'module'
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
    public function testMatch($route, $controller, $nodeId, $moduleParams, $pathinfo)
    {
        if ($pathinfo == 'unknownPath') {
            $this->setExpectedException('Symfony\Component\Routing\Exception\ResourceNotFoundException');
            $this->matcher->match($pathinfo);
        } else {
            $parameters = $this->matcher->match($pathinfo);
            
            $this->assertEquals($route, $parameters['_route']);
            $this->assertEquals($controller, $parameters['_controller']);
            $this->assertEquals($nodeId, $parameters['nodeId']);
            if ($moduleParams != '') {
                $this->assertEquals($moduleParams, $parameters['module_parameters']);
            }
        }
    }
    
    
    public function getFromCacheCallback($pathinfo)
    {
        if (isset($this->cache[$pathinfo])) {
            return $this->cache[$pathinfo];
        } else {
            return null;
        }
    }
    
    // route, controller, nodeId, moduleParams, pathinfo
    public function matchDataProvider()
    {
        return array(
            array(
                'phporchestra_cms_node',
                'PHPOrchestra\\CMSBundle\\Controller\\NodeController::showAction',
                2,
                '',
                '/test/'
            ),
            array(
                'phporchestra_cms_module',
                'PHPOrchestra\\CMSBundle\\Controller\\NodeController::showAction',
                3,
                array('param1', 'param2'),
                '/test/module/param1/param2'
            ),
            array(
                'phporchestra_cms_module',
                'PHPOrchestra\\CMSBundle\\Controller\\NodeController::showAction',
                3,
                array(),
                '/test/module'
            ),
            array(
                'phporchestra_cms_module',
                'PHPOrchestra\\CMSBundle\\Controller\\NodeController::showAction',
                3,
                array('param1'),
                '/test-cache'
            ),
            array(
                '',
                '',
                '',
                '',
                'unknownPath'
            ),
            
        );
    }
}
