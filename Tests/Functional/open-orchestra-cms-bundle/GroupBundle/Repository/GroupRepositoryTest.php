<?php

namespace OpenOrchestra\GroupBundle\Tests\Functional\Repository;

use OpenOrchestra\BaseBundle\Tests\AbstractTest\AbstractKernelTestCase;
use OpenOrchestra\Pagination\Configuration\FinderConfiguration;
use OpenOrchestra\Pagination\Configuration\PaginateFinderConfiguration;
use OpenOrchestra\UserBundle\Repository\GroupRepository;

/**
 * Class GroupRepositoryTest
 *
 * @group integrationTest
 */
class GroupRepositoryTest extends AbstractKernelTestCase
{
    /**
     * @var GroupRepository
     */
    protected $repository;

    /**
     * Set up test
     */
    protected function setUp()
    {
        parent::setUp();

        static::bootKernel();
        $this->repository = static::$kernel->getContainer()->get('open_orchestra_user.repository.group');
    }

    /**
     * @param array  $descriptionEntity
     * @param array  $search
     * @param array  $order
     * @param int    $skip
     * @param int    $limit
     * @param int    $count
     *
     * @dataProvider providePaginateAndSearch
     */
    public function testFindForPaginate($descriptionEntity, $search, $order, $skip, $limit, $count)
    {
        $configuration = PaginateFinderConfiguration::generateFromVariable($descriptionEntity, $search);
        $configuration->setPaginateConfiguration($order, $skip, $limit);
        $groups = $this->repository->findForPaginate($configuration);
        $this->assertCount($count, $groups);
    }

    /**
     * @return array
     */
    public function providePaginateAndSearch()
    {
        $descriptionEntity = $this->getDescriptionColumnEntity();

        return array(
            array($descriptionEntity, null, null, 0 ,5 , 5),
            array($descriptionEntity, $this->generateSearchProvider('group'), null, 0 ,5 , 5),
            array($descriptionEntity, $this->generateSearchProvider('', 'group'), null, 0 ,5 , 5),
            array($descriptionEntity, $this->generateSearchProvider('', 'fakeGroup'), null, 0 ,5 , 0),
            array($descriptionEntity, $this->generateSearchProvider('Demo'), null, 0 ,5 , 1),
        );
    }

    /**
     * test count all user
     */
    public function testCount()
    {
        $groups = $this->repository->count();
        $this->assertEquals(7, $groups);
    }

    /**
     * find all group with site
     *
     * @return array
     */
    public function testFindAllWithSite()
    {
        $groups = $this->repository->findAllWithSite();
        $this->assertCount(6, $groups);
    }

    /**
     * @param array  $descriptionEntity
     * @param array  $search
     * @param int    $count
     *
     * @dataProvider provideColumnsAndSearchAndCount
     */
    public function testCountWithFilter($descriptionEntity, $search, $count)
    {
        $configuration = FinderConfiguration::generateFromVariable($descriptionEntity, $search);
        $groups = $this->repository->countWithFilter($configuration);
        $this->assertEquals($count, $groups);
    }

    /**
     * @return array
     */
    public function provideColumnsAndSearchAndCount(){
        $descriptionEntity = $this->getDescriptionColumnEntity();

        return array(
            array($descriptionEntity, null, 7),
            array($descriptionEntity, $this->generateSearchProvider('group'), 6),
            array($descriptionEntity, $this->generateSearchProvider('Demo'), 1),
            array($descriptionEntity, $this->generateSearchProvider('', 'fakeName'), 0),
        );
    }

    /**
     * Generate columns of content with search value
     *
     * @param string $searchName
     * @param string $globalSearch
     *
     * @return array
     */
    protected function generateSearchProvider($searchName = '', $globalSearch = '')
    {
        $search = array();
        if (!empty($searchName)) {
            $search['columns'] = array('name' => $searchName);
        }
        if (!empty($globalSearch)) {
            $search['global'] = $globalSearch;
        }

        return $search;
    }

    /**
     * Generate relation between columns names and entities attributes
     *
     * @return array
     */
    protected function getDescriptionColumnEntity()
    {

        return array(
            'name' => array('key' => 'name', 'field' => 'name', 'type' => 'string')
        );
    }

}
