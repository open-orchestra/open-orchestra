<?php

namespace PHPOrchestra\CMSBundle\Test\Model;

use PHPOrchestra\CMSBundle\Model\FieldIndexRepository;

class FieldIndexRepositoryTest extends \PHPUnit_Framework_TestCase
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
                'Model\PHPOrchestraCMSBundle\FieldIndex' => array(
                     1 => array('fieldName' => '_title', 'fieldType' => 's'),
                     2 => array('fieldName' => '_news', 'fieldType' => 't'),
                     3 => array('fieldName' => '_author', 'fieldType' => 's')
                )
            )
        );
        
        $this->repository = new FieldIndexRepository($this->mandango);
    }


    public function testGetAll()
    {
        $result = $this->repository->getAll();
        $this->assertEquals("_title", $result[1]->getFieldName());
    }
}
