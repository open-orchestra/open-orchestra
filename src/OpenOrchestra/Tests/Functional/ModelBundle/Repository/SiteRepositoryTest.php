<?php

namespace OpenOrchestra\FunctionalTests\ModelBundle\Repository;

use OpenOrchestra\BaseBundle\Tests\AbstractTest\AbstractKernelTestCase;
use OpenOrchestra\ModelBundle\Repository\SiteRepository;
use OpenOrchestra\Pagination\Configuration\FinderConfiguration;
use OpenOrchestra\Pagination\Configuration\PaginateFinderConfiguration;

/**
 * Class SiteRepositoryTest
 *
 * @group integrationTest
 */
class SiteRepositoryTest extends AbstractKernelTestCase
{
    /**
     * @var SiteRepository
     */
    protected $repository;

    /**
     * Set up test
     */
    protected function setUp()
    {
        parent::setUp();

        static::bootKernel();
        $this->repository = static::$kernel->getContainer()->get('open_orchestra_model.repository.site');
    }

    /**
     * @param boolean $deleted
     * @param array   $descriptionEntity
     * @param array   $search
     * @param int     $skip
     * @param int     $limit
     * @param integer $count
     *
     * @dataProvider provideDeletedAndPaginateAndSearch
     */
    public function testFindByDeletedForPaginate($deleted, $descriptionEntity, $search, $skip, $limit, $count)
    {
        $this->markTestSkipped('To unskip when group list is refacto');
        $configuration = PaginateFinderConfiguration::generateFromVariable($descriptionEntity, $search);
        $configuration->setPaginateConfiguration(null, $skip, $limit);
        $sites = $this->repository->findByDeletedForPaginate($deleted, $configuration);
        $this->assertCount($count, $sites);
    }

    /**
     * @return array
     */
    public function provideDeletedAndPaginateAndSearch()
    {
        $descriptionEntity = $this->getDescriptionColumnEntity();

        return array(
            array(false, array(), null, 0 ,1 , 1),
            array(true, array(), null, 0 ,2 , 1),
            array(false, $descriptionEntity, $this->generateSearchProvider(array('site_id' => '2'), 'demo'), null, null, 1),
            array(false, $descriptionEntity, $this->generateSearchProvider(array('site_id' => '1'), 'demo'), null, null, 0),
            array(false, $descriptionEntity, $this->generateSearchProvider(array('site_id' => '1', 'name' => 'demo')), null, null, 0),
            array(false, $descriptionEntity, $this->generateSearchProvider(null, 'fake search'), null, null, 0)
        );
    }

    /**
     * @param array   $descriptionEntity
     * @param array   $search
     * @param int     $skip
     * @param int     $limit
     * @param integer $count
     *
     * @dataProvider providePaginateSearch
     */
    public function testFindForPaginate($descriptionEntity, $search, $skip, $limit, $count)
    {
        $this->markTestSkipped('To unskip when group list is refacto');
        $configuration = PaginateFinderConfiguration::generateFromVariable($descriptionEntity, $search);
        $configuration->setPaginateConfiguration(null, $skip, $limit);
        $sites = $this->repository->findForPaginate($configuration);
        $this->assertCount($count, $sites);
    }

    /**
     * @return array
     */
    public function providePaginateSearch()
    {
        $descriptionEntity = $this->getDescriptionColumnEntity();

        return array(
            array(array(), $this->generateSearchProvider(array('deleted' => false)), 0 ,1 , 1),
            array(array(), $this->generateSearchProvider(array('deleted' => true)), 0 ,1 , 1),
            array($descriptionEntity, $this->generateSearchProvider(array('deleted' => false, 'site_id' => '2'), 'demo'), null, null, 1),
            array($descriptionEntity, $this->generateSearchProvider(array('deleted' => false, 'site_id' => '1'), 'demo'), null, null, 0),
            array($descriptionEntity, $this->generateSearchProvider(array('deleted' => false, 'site_id' => '1', 'name' => 'demo')), null, null, 0),
            array($descriptionEntity, $this->generateSearchProvider(null, 'fake search'), null, null, 0)
        );
    }

    /**
     * @param boolean $deleted
     * @param integer $count
     *
     * @dataProvider provideBooleanDeletedCount
     */
    public function testCountByDeleted($deleted, $count)
    {
        $sites = $this->repository->countByDeleted($deleted);
        $this->assertEquals($count, $sites);
    }

    /**
     * @return array
     */
    public function provideBooleanDeletedCount()
    {
        return array(
            array(true, 1),
        );
    }

    /**
     * @param boolean $deleted
     * @param array   $descriptionEntity
     * @param array   $search
     * @param int     $count
     *
     * @dataProvider provideColumnsAndSearchAndCount
     */
    public function testCountWithSearchFilterByDeleted($deleted, $descriptionEntity, $search, $count)
    {
        $configuration = FinderConfiguration::generateFromVariable($descriptionEntity, $search);
        $sites = $this->repository->countWithSearchFilterByDeleted($deleted, $configuration);
        $this->assertEquals($count, $sites);
    }

    /**
     * @return array
     */
    public function provideColumnsAndSearchAndCount()
    {
        $descriptionEntity = $this->getDescriptionColumnEntity();

        return array(
            array(false, $descriptionEntity, $this->generateSearchProvider(array('site_id' => '2'), 'demo'), 1),
            array(false, $descriptionEntity, $this->generateSearchProvider(array('site_id' => '1'), 'demo'), 0),
            array(true, $descriptionEntity, $this->generateSearchProvider(null, 'fake search'), 0)
        );
    }

    /**
     * @param string        $domain
     * @param array<string> $expectedSiteIds
     *
     * @dataProvider provideAliasDomain
     */
    public function testFindByAliasDomain($domain, $expectedSiteIds)
    {
        $sites = $this->repository->findByAliasDomain($domain);

        $this->assertIdsMatches($expectedSiteIds, $sites);
    }

    /**
     * Check if the $sites ids matches $expectedIds
     *
     * @param array $expectedIds
     * @param array $sites
     */
    protected function assertIdsMatches($expectedIds, $sites)
    {
        if (count($expectedIds) != count($sites)) {

            return false;
        }

        foreach ($sites as $site) {
            if (!in_array($site->getSiteId(), $expectedIds)) {

                return false;
            }
        }

        return true;
    }

    /**
     * @return array
     */
    public function provideAliasDomain()
    {
        return array(
            array('front.pddv-openorchestra-master.eolas-services.com', array('2')),
            array('fakeDomain', array())
        );
    }

    /**
     * Generate columns of site with search value
     *
     * @param array|null  $searchColumns
     * @param string      $globalSearch
     *
     * @return array
     */
    protected function generateSearchProvider($searchColumns = null, $globalSearch = '')
    {
        $search = array();
        if (null !== $searchColumns) {
            $columns = array();
            foreach ($searchColumns as $name => $value) {
                $columns[$name] = $value;
            }
            $search['columns'] = $columns;
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
            'site_id' => array('key' => 'site_id', 'field' => 'siteId', 'type' => 'string'),
            'name' => array('key' => 'name', 'field' => 'name', 'type' => 'string'),
            'deleted' => array('key' => 'deleted', 'field' => 'deleted', 'type' => 'boolean'),
        );
    }

    /**
     * @param array $sites
     * @param array $orderId
     */
    protected function assertSameOrder($sites, $orderId)
    {
        foreach ($sites as $index => $site) {
            $this->assertEquals($site->getSiteId(), $orderId[$index]);
        }
    }
}
