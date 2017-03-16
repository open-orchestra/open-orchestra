<?php

namespace OpenOrchestra\FunctionalTests\ModelBundle\Repository;

use OpenOrchestra\BaseBundle\Tests\AbstractTest\AbstractKernelTestCase;
use OpenOrchestra\ModelBundle\Repository\StatusRepository;
use OpenOrchestra\Pagination\Configuration\PaginateFinderConfiguration;

/**
 * Test StatusRepositoryTest
 *
 * @group integrationTest
 */
class StatusRepositoryTest extends AbstractKernelTestCase
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
        $this->repository = static::$kernel->getContainer()->get('open_orchestra_model.repository.status');
    }

    /**
     * test find not out of workflow
     */
    public function testFindNotOutOfWorkflow()
    {
        $statuses = $this->repository->findNotOutOfWorkflow();
        $this->assertCount(5, $statuses);
        foreach ($statuses as $status) {
            $this->assertFalse($status->isOutOfWorkflow());
        }
    }

    /**
     * test find one by translation state
     */
    public function testFindOneByTranslationState()
    {
        $status = $this->repository->findOneByTranslationState();
        $this->assertTrue($status->isTranslationState());
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
     * test count
     */
    public function testCountNotOutOfWorkflow()
    {
        $this->assertSame(5, $this->repository->CountNotOutOfWorkflow());
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

    /**
     * Provide PaginateFinderConfiguration
     *
     * @return array
     */
    public function providePaginateConfiguration()
    {
        $mapping =  array('label' => 'labels');
        $conf1 = PaginateFinderConfiguration::generateFromVariable(null , null, null, $mapping, null);
        $conf2 = PaginateFinderConfiguration::generateFromVariable(null , null, null, $mapping, array('label' => 'o', 'language' => 'en'));
        $conf3 = PaginateFinderConfiguration::generateFromVariable(null , 2   , 4   , $mapping, array('label' => 'r', 'language' => 'en'));

        return array(
            'No criteria'                => array($conf1, 5, 5),
            'Filtering "o"'              => array($conf2, 2, 2),
            'Filtering 2 items with "r"' => array($conf3, 0, 2),
        );
    }

    /**
     * Test remove statuses
     */
    public function testRemoveStatuses()
    {
        $dm = static::$kernel->getContainer()->get('object_manager');
        $statusPending = $this->repository->findOneByName('pending');
        $statusPublished = $this->repository->findOneByName('published');

        $statusIds = array($statusPending->getId(), $statusPublished->getId());

        $this->repository->removeStatuses($statusIds);
        $this->assertNull($this->repository->findOneByName('pending'));
        $this->assertNull($this->repository->findOneByName('published'));

        $dm->persist(clone $statusPending);
        $dm->persist(clone $statusPublished);
        $dm->flush();
    }
 }
