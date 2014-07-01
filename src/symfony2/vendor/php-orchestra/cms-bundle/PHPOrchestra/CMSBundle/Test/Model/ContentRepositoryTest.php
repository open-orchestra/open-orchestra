<?php

namespace PHPOrchestra\CMSBundle\Test\Model;

use PHPOrchestra\CMSBundle\Model\ContentRepository;

class ContentRepositoryTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Database mock system
     *
     * @var \PHPOrchestra\CMSBundle\Test\Mock\Mandango
     */
    protected $mandango = null;
    
    /**
     * repository to be tested
     *
     * @var PHPOrchestra\CMSBundle\Model\NodeRepository
     */
    protected $repository = null;


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
                'Model\PHPOrchestraCMSBundle\Content' => array(
                    1 => array(
                        'contentId' => 1,
                        'contentType' => 'news',
                        'version' => 1,
                        'language' => 'fr',
                        'status' => 'published',
                        'shortName' => 'Bien vivre en France',
                        'contentTypeVersion' => 1,
                        'deleted' => false
                    ),
                    2 => array(
                        'contentId' => 2,
                        'contentType' => 'news',
                        'version' => 1,
                        'language' => 'fr',
                        'status' => 'published',
                        'shortName' => 'Lorem ipsum',
                        'contentTypeVersion' => 1,
                        'deleted' => true
                    ),
                    3 => array(
                        'contentId' => 3,
                        'contentType' => 'car',
                        'version' => 2,
                        'language' => 'fr',
                        'status' => 'published',
                        'shortName' => 'R5 3 portes',
                        'contentTypeVersion' => 1,
                        'deleted' => true
                    ),
                )
            )
        );
        
        $this->repository = new ContentRepository($this->mandango);
    }


    public function testGetAllContents()
    {
        $result = $this->repository->getAllContents();
        $this->assertEquals('Bien vivre en France', $result[1]->getShortName());
    }

    
/*    public function testGetOne()
    {
    	$result = $this->repository->getOne(1);
    	var_dump($result);
    	$this->assertEquals('Bien vivre en France', $result);
    }*/


    public function testGetAllToIndex()
    {
        $result = $this->repository->getAllToIndex();
        $this->assertEquals('Bien vivre en France', $result[1]->getShortName());
    }
}
