<?php

namespace PHPOrchestra\CMSBundle\Test\Routing;

use PHPOrchestra\CMSBundle\Routing\PhpOrchestraUrlGenerator;
use Model\PHPOrchestraCMSBundle\Node;
use PHPOrchestra\CMSBundle\Document\DocumentManager;

/**
 * Tests of PhpOrchestraUrlGenerator
 *
 * @author Noël GILAIN <oel.gilain@businessdecision.com>
 */
class PhpOrchestraUrlGeneratorTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $routes = $this->getMockBuilder('Symfony\\Component\\Routing\\RouteCollection')
                ->enableProxyingToOriginalMethods()
                ->getMock();
        
        $context = $this->getMock('Symfony\\Component\\Routing\\RequestContext');
        
        $context->expects($this->any())
            ->method('getScheme')
            ->will($this->returnCallback(array($this, 'schemeCallback')));
        
        $context->expects($this->any())
            ->method('getHttpPort')
            ->will($this->returnValue('8080'));
            $context->expects($this->any())
            ->method('getHttpsPort')
            ->will($this->returnValue('444'));
        
        $context
            ->expects($this->any())
            ->method('getHost')
            ->will($this->returnValue('some-site.com'));
            
        
        $documentServices = $this->getMockBuilder('PHPOrchestra\\CMSBundle\\Test\\Mock\\Mandango')
                ->enableProxyingToOriginalMethods()
                ->getMock();
        
        $documentServices->setDB(
            array(
                'Model\PHPOrchestraCMSBundle\Node' => array(
                    1 => array(
                        '_id'       => '1',
                        'node_id'   => Node::ROOT_NODE_ID,
                        'parent_id' => 0,
                        'alias'     => '',
                        'node_type' => 'page'
                    ),
                    2 => array(
                        '_id'       => '2',
                        'node_id'   => 'page1',
                        'parent_id' => Node::ROOT_NODE_ID,
                        'alias'     => 'page',
                        'node_type' => 'page'
                    ),
                    3 => array(
                        '_id'       => '3',
                        'node_id'   => 'page2',
                        'parent_id' => 'page1',
                        'alias'     => 'sub-page',
                        'node_type' => 'page'
                    ),
                )
            )
        );
        
        $documentManager = new DocumentManager($documentServices);
        
        $this->generator = new PhpOrchestraUrlGenerator(
            $routes,
            $context,
            $documentManager
        );
    }

    /**
     * @dataProvider generateDataProvider
     */
    public function testGenerate($scheme, $nodeId, $refType, $expected)
    {
        if ('unknownId' == $nodeId) {
            $this->setExpectedException($expected);
            $this->generator->generate($nodeId, array(), $refType);
        } else {
            $this->scheme = $scheme;
            
            $this->assertEquals(
                $expected,
                $this->generator->generate($nodeId, array(), $refType)
            );
        }
    }
    
    public function schemeCallback()
    {
        return $this->scheme;
    }
    
    //  ABSOLUTE_URL NETWORK_PATH RELATIVE_PATH
    public function generateDataProvider()
    {
        return array(
            array(
                'http',
                'page2',
                PhpOrchestraUrlGenerator::RELATIVE_PATH,
                'page/sub-page'
            ),
            array(
                'https',
                'page1',
                PhpOrchestraUrlGenerator::ABSOLUTE_URL,
                'https://some-site.com:444/page'
            ),
            array(
                'http',
                'page1',
                PhpOrchestraUrlGenerator::NETWORK_PATH,
                '//some-site.com:8080/page'
            ),
            array(
                'http',
                'unknownId',
                PhpOrchestraUrlGenerator::RELATIVE_PATH,
                'Symfony\Component\Routing\Exception\RouteNotFoundException'
            ),
        );
    }
}
