<?php

namespace PHPOrchestra\CMSBundle\Test\Model;

use PHPOrchestra\CMSBundle\Model\ListIndexRepository;

/**
 * Test unit
 * 
 * @author Benjamin Fouché <benjamin.fouche@businessdecision.com>
 *
 */
class ListIndexRepositoryTest extends \PHPUnit_Framework_TestCase
{

    /**
     * repository to be tested
     *
     * @var PHPOrchestra\CMSBundle\Model\NodeRepository
     */
    protected $repository = null;
    
    /**
     * Database mock system
     *
     * @var \PHPOrchestra\CMSBundle\Test\Mock\Mandango
     */
    protected $mandango = null;


    /**
     * Tests setup
     */
    public function setUp()
    {
        /**
         * Database mock system, using a fake result set
         *
         * @var \PHPOrchestra\CMSBundle\Test\Mock\Mandango
         */
        $this->mandango = $this->getMockBuilder('PHPOrchestra\\CMSBundle\\Test\\Mock\\Mandango')
            ->enableProxyingToOriginalMethods()
            ->getMock();
        
        $this->mandango->setDB(
            array(
                'Model\PHPOrchestraCMSBundle\ListIndex' => array(
                     1 => array('nodeId' => 'fixture_full'),
                     2 => array('contentId' => 3),
                     3 => array('nodeId' => 'fixture_bd')
                )
            )
        );
        
        $this->repository = new ListIndexRepository($this->mandango);
    }


    /**
     * Test getAll()
     */
    public function testGetAll()
    {
        $result = $this->repository->getAll();
        $this->assertEquals("fixture_full", $result[1]->getNodeId());
    }


    /**
     * Test removeByDocId()
     */
    public function testRemoveByDocId()
    {
        $this->repository->removeByDocId('fixture_full');
    }
}
