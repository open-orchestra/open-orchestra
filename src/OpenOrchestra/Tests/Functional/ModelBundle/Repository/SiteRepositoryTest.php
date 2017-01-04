<?php

namespace OpenOrchestra\FunctionalTests\ModelBundle\Repository;

use OpenOrchestra\BaseBundle\Tests\AbstractTest\AbstractKernelTestCase;
use OpenOrchestra\ModelBundle\Repository\SiteRepository;
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
     * @param PaginateFinderConfiguration  $configuration
     * @param array|null                   $siteIds
     * @param int                          $count
     *
     * @dataProvider providePaginateAndSearch
     */
    public function testFindForPaginate(PaginateFinderConfiguration $configuration, $siteIds, $count)
    {
        $sites = $this->repository->findForPaginateFilterBySiteIds($configuration, $siteIds);
        $this->assertCount($count, $sites);
    }

    /**
     * @return array
     */
    public function providePaginateAndSearch()
    {
        $configurationAll = PaginateFinderConfiguration::generateFromVariable(array(), 0, 100, array());
        $configurationLimit = PaginateFinderConfiguration::generateFromVariable(array(), 0, 1, array());
        $configurationSearch = PaginateFinderConfiguration::generateFromVariable(array(), 0, 100, array(), array('name' => 'demo'));
        $configurationAllOrder = PaginateFinderConfiguration::generateFromVariable(array('name' => 'desc'), 0, 100, array());

        return array(
            'all' => array($configurationAll, null, 1),
            'all with site' => array($configurationAll, array('2'), 1),
            'all with deleted site' => array($configurationAll, array('3'), 0),
            'all without site' => array($configurationAll, array(), 0),
            'limit' => array($configurationLimit, null, 1),
            'search' => array($configurationSearch, null, 1),
            'search without site' => array($configurationSearch, array(), 0),
            'order' => array($configurationAllOrder, null, 1),
        );
    }

    /**
     * test count all site
     */
    public function testCount()
    {
        $sites = $this->repository->countFilterBySiteIds();
        $this->assertEquals(1, $sites);
    }

    /**
     * test count all site with site ids
     */
    public function testCountWithIds()
    {
        $sites = $this->repository->countFilterBySiteIds(array('2'));
        $this->assertEquals(1, $sites);
    }

    /**
     * @param PaginateFinderConfiguration $configuration
     * @param array|null                  $siteIds
     * @param int                         $count
     *
     * @dataProvider provideCountWithFilter
     */
    public function testCountWithFilter($configuration, $siteIds, $count)
    {
        $sites = $this->repository->countWithFilterAndSiteIds($configuration, $siteIds);
        $this->assertEquals($count, $sites);
    }

    /**
     * @return array
     */
    public function provideCountWithFilter()
    {
        $configurationAll = PaginateFinderConfiguration::generateFromVariable(array(), 0, 100, array());
        $configurationLimit = PaginateFinderConfiguration::generateFromVariable(array(), 0, 1, array());
        $configurationSearch = PaginateFinderConfiguration::generateFromVariable(array(), 0, 100, array(), array('name' => 'demo'));
        $configurationAllOrder = PaginateFinderConfiguration::generateFromVariable(array('name' => 'desc'), 0, 100, array());

        return array(
            'all' => array($configurationAll, null, 1),
            'all with site' => array($configurationAll, array('2'), 1),
            'all with deleted site' => array($configurationAll, array('3'), 0),
            'all without site' => array($configurationAll, array(), 0),
            'limit' => array($configurationLimit, null, 1),
            'search' => array($configurationSearch, null, 1),
            'search without site' => array($configurationSearch, array(), 0),
            'order' => array($configurationAllOrder, null, 1),
        );
    }

    /**
     * Check if the $sites ids matches $expectedIds
     *
     * @param array $expectedIds
     * @param array $sites
     *
     * @return boolean
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
}
