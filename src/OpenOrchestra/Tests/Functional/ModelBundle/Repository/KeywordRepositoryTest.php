<?php

namespace OpenOrchestra\FunctionalTests\ModelBundle\Repository;

use OpenOrchestra\BaseBundle\Tests\AbstractTest\AbstractKernelTestCase;
use OpenOrchestra\ModelInterface\Repository\KeywordRepositoryInterface;
use OpenOrchestra\Pagination\Configuration\PaginateFinderConfiguration;

/**
 * Class KeywordRepositoryTest
 *
 * @group integrationTest
 */
class KeywordRepositoryTest extends AbstractKernelTestCase
{
    /**
     * @var KeywordRepositoryInterface
     */
    protected $repository;

    /**
     * Set up test
     */
    protected function setUp()
    {
        parent::setUp();

        static::bootKernel();
        $this->repository = static::$kernel->getContainer()->get('open_orchestra_model.repository.keyword');
    }

    /**
     * @param PaginateFinderConfiguration  $configuration
     * @param int                          $count
     *
     * @dataProvider providePaginateAndSearch
     */
    public function testFindForPaginate(PaginateFinderConfiguration $configuration, $count)
    {
        $keywords = $this->repository->findForPaginate($configuration);
        $this->assertCount($count, $keywords);
    }

    /**
     * @return array
     */
    public function providePaginateAndSearch()
    {
        $configurationAll = PaginateFinderConfiguration::generateFromVariable(array(), 0, 100, array());
        $configurationLimit = PaginateFinderConfiguration::generateFromVariable(array(), 0, 1, array());
        $configurationSearch = PaginateFinderConfiguration::generateFromVariable(array(), 0, 100, array(), array('label' => 'lorem'));
        $configurationAllOrder = PaginateFinderConfiguration::generateFromVariable(array('label' => 'desc'), 0, 100, array());

        return array(
            'all' => array($configurationAll, 5),
            'limit' => array($configurationLimit, 1),
            'search' => array($configurationSearch, 1),
            'order' => array($configurationAllOrder, 5),
        );
    }

    /**
     * test count all keyword
     */
    public function testCount()
    {
        $keywords = $this->repository->count();
        $this->assertEquals(5, $keywords);
    }

    /**
     * @param PaginateFinderConfiguration $configuration
     * @param int                         $count
     *
     * @dataProvider provideCountWithFilter
     */
    public function testCountWithFilter($configuration, $count)
    {
        $keywords = $this->repository->countWithFilter($configuration);
        $this->assertEquals($count, $keywords);
    }

    /**
     * @return array
     */
    public function provideCountWithFilter()
    {
        $configurationAll = PaginateFinderConfiguration::generateFromVariable(array(), 0, 100, array());
        $configurationLimit = PaginateFinderConfiguration::generateFromVariable(array(), 0, 1, array());
        $configurationSearch = PaginateFinderConfiguration::generateFromVariable(array(), 0, 100, array(), array('label' => 'lorem'));

        return array(
            'all' => array($configurationAll, 5),
            'limit' => array($configurationLimit, 5),
            'search' => array($configurationSearch, 1),
        );
    }

    /**
     * Test remove keywords
     */
    public function testRemoveKeywords()
    {
        $dm = static::$kernel->getContainer()->get('object_manager');
        $lorem = $this->repository->findOneByLabel('lorem');
        $dolor = $this->repository->findOneByLabel('dolor');

        $keywordIds = array($lorem->geTId(), $dolor->getId());

        $this->repository->removeKeywords($keywordIds);
        $this->assertNull($this->repository->findOneByLabel('lorem'));
        $this->assertNull($this->repository->findOneByLabel('dolor'));

        $dm->persist(clone $lorem);
        $dm->persist(clone $dolor);
        $dm->flush();
    }
}
