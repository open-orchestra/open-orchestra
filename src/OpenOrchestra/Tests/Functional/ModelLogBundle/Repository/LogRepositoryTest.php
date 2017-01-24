<?php

namespace OpenOrchestra\FunctionalTests\ModelLogBundle\Repository;

use OpenOrchestra\BaseBundle\Tests\AbstractTest\AbstractKernelTestCase;
use OpenOrchestra\ModelBundle\Repository\StatusRepository;
use OpenOrchestra\Pagination\Configuration\PaginateFinderConfiguration;

/**
 * Test LogRepositoryTest
 *
 * @group integrationTest
 */
class LogRepositoryTest extends AbstractKernelTestCase
{
    /**
     * @var StatusRepository
     */
    protected $repository;

    /**
     * Set up the test
     */
    public function setUp()
    {
        parent::setUp();

        static::bootKernel();
        $this->repository = static::$kernel->getContainer()->get('open_orchestra_log.repository.log');
    }

    /**
     * test findForPaginate
     *
     * @param PaginateFinderConfiguration $configuration
     * @param int                         $expectedCount
     * @param int                         $expectedFilteredCount
     *
     * @dataProvider providePaginateConfiguration
     */
    public function testFindForPaginate(PaginateFinderConfiguration $configuration, $expectedCount, $expectedFilteredCount)
    {
       $this->assertCount($expectedCount, $this->repository->findForPaginate($configuration));
    }

    /**
     * Provide PaginateFinderConfiguration
     *
     * @return array
     */
    public function providePaginateConfiguration()
    {
        $mapping = array(
            'date_time' => 'datetime',
            'user_ip'   => 'extra.user_ip',
            'user_name' => 'extra.user_name',
            'message'   => 'message'
        );
        $conf1 = PaginateFinderConfiguration::generateFromVariable(null , null, null, $mapping, array(
            'site_id' => 'fixture'
        ));
        $conf2 = PaginateFinderConfiguration::generateFromVariable(null , null, null, $mapping, array(
            'site_id' => 'fixture', 'date' => '2016/02/10', 'date-format' => 'yy/mm/dd'
        ));
        $conf3 = PaginateFinderConfiguration::generateFromVariable(null , null, null, $mapping, array(
            'site_id' => 'fixture', 'user_ip' => '5'
        ));
        $conf4 = PaginateFinderConfiguration::generateFromVariable(null , null, null, $mapping, array(
            'site_id' => 'fixture', 'user_name' => 'developer'
        ));

        return array(
            'No criteria'       => array($conf1, 9, 9),
            'Filtering on date' => array($conf2, 5, 5),
            'Filtering ip'      => array($conf3, 3, 3),
            'Filtering name'    => array($conf4, 4, 4),
        );
    }

    /**
     * test count
     */
    public function testCount()
    {
        $this->assertSame(32, $this->repository->count());
    }

    /**
     * test countWithFilter
     *
     * @param PaginateFinderConfiguration $configuration
     * @param int                         $expectedCount
     * @param int                         $expectedFilteredCount
     *
     * @dataProvider providePaginateConfiguration
     */
    public function testCountWithFilter(PaginateFinderConfiguration $configuration, $expectedCount, $expectedFilteredCount)
    {
       $this->assertSame($expectedFilteredCount, $this->repository->countWithFilter($configuration));
    }
 }
