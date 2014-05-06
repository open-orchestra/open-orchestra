<?php

namespace PHPOrchestra\CMSBundle\Test\Routing;

use PHPOrchestra\CMSBundle\Routing\PhpOrchestraUrlGenerator;
use Model\PHPOrchestraCMSBundle\Node;

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
        
        $documentManager = $this->getMockBuilder('PHPOrchestra\\CMSBundle\\Test\\Mock\\Mandango')
                ->enableProxyingToOriginalMethods()
                ->getMock();
        
        $documentManager->setDB(
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
        
        $this->generator = new PhpOrchestraUrlGenerator(
            $routes,
            $context,
            $documentManager
        );
    }


    /**
     * @dataProvider generateDataProvider
     */
    public function testGenerate($scheme, $nodeId, $refType, $expectedUrl)
    {
     /*   $this->generator->context
            ->expects($this->any())
            ->method('getScheme')
            ->will($this->returnValue($scheme));*/
        
      /*  $this->context
            ->expects($this->any())
            ->method('getPathInfo')
            ->will($this->returnValue('/'));*/
        
    /*    $this->assertEquals(
            $expectedUrl,
            $this->generator->generate($nodeId, array(), $refType)
            );*/
    }
    
//  ABSOLUTE_PATH NETWORK_PATH RELATIVE_PATH
    public function generateDataProvider()
    {
        return array(
            array(
                'http',
                'page2',
                PhpOrchestraUrlGenerator::RELATIVE_PATH,
                './page/sub-page'
            ),
        );
    }
    
}