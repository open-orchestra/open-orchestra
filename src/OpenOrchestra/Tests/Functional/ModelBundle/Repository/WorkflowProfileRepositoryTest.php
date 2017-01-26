<?php

namespace OpenOrchestra\FunctionalTests\ModelBundle\Repository;

use OpenOrchestra\BaseBundle\Tests\AbstractTest\AbstractKernelTestCase;
use OpenOrchestra\ModelInterface\Repository\WorkflowProfileRepositoryInterface;
use OpenOrchestra\Pagination\Configuration\PaginateFinderConfiguration;

/**
 * Class WorkflowProfileRepositoryTest
 *
 * @group integrationTest
 */
class WorkflowProfileRepositoryTest extends AbstractKernelTestCase
{
    /**
     * @var WorkflowProfileRepositoryInterface
     */
    protected $repository;

    protected $statusRepository;

    /**
     * Set up test
     */
    protected function setUp()
    {
        parent::setUp();

        static::bootKernel();
        $this->repository = static::$kernel->getContainer()->get('open_orchestra_model.repository.workflow_profile');
        $this->statusRepository = static::$kernel->getContainer()->get('open_orchestra_model.repository.status');
    }

    /**
     * Test hasTransition
     *
     * @param string  $fromStatusName
     * @param string  $toStatusName
     * @param boolean $expectedBool
     *
     * @dataProvider provideTransitions
     */
    public function testHasTransition($fromStatusName, $toStatusName, $expectedBool)
    {
        $statusFrom = $this->statusRepository->findOneByName($fromStatusName);
        $statusTo = $this->statusRepository->findOneByName($toStatusName);

        $this->assertSame($expectedBool, $this->repository->hasTransition($statusFrom, $statusTo));
    }

    /**
     * Provide transition status
     *
     * @return array
     */
    public function provideTransitions()
    {
        return array(
            array('draft', 'toTranslate', false),
            array('draft', 'published'  , true),
        );
    }

    /**
     * @param PaginateFinderConfiguration  $configuration
     * @param int                          $count
     *
     * @dataProvider providePaginateAndSearch
     */
    public function testFindForPaginate(PaginateFinderConfiguration $configuration, $count)
    {
        $workflowProfiles = $this->repository->findForPaginate($configuration);
        $this->assertCount($count, $workflowProfiles);
    }

    /**
     * @return array
     */
    public function providePaginateAndSearch()
    {
        $configurationAll = PaginateFinderConfiguration::generateFromVariable(array(), 0, 100, array());
        $configurationLimit = PaginateFinderConfiguration::generateFromVariable(array(), 0, 1, array());
        $configurationSearch = PaginateFinderConfiguration::generateFromVariable(array(), 0, 100, array(), array('label' => 'Contributor', 'language' => 'en'));
        $configurationAllOrder = PaginateFinderConfiguration::generateFromVariable(array('label' => 'desc'), 0, 100, array());

        return array(
            'all' => array($configurationAll, 2),
            'limit' => array($configurationLimit, 1),
            'search' => array($configurationSearch, 1),
            'order' => array($configurationAllOrder, 2),
        );
    }

    /**
     * test count all workflow profile
     */
    public function testCount()
    {
        $workflowProfiles = $this->repository->count();
        $this->assertEquals(2, $workflowProfiles);
    }

    /**
     * @param PaginateFinderConfiguration $configuration
     * @param int                         $count
     *
     * @dataProvider provideCountWithFilter
     */
    public function testCountWithFilter($configuration, $count)
    {
        $workflowProfiles = $this->repository->countWithFilter($configuration);
        $this->assertEquals($count, $workflowProfiles);
    }

    /**
     * @return array
     */
    public function provideCountWithFilter()
    {
        $configurationAll = PaginateFinderConfiguration::generateFromVariable(array(), 0, 100, array());
        $configurationLimit = PaginateFinderConfiguration::generateFromVariable(array(), 0, 1, array());
        $configurationSearch = PaginateFinderConfiguration::generateFromVariable(array(), 0, 100, array(), array('label' => 'Contributor', 'language' => 'en'));
        $configurationAllOrder = PaginateFinderConfiguration::generateFromVariable(array('label' => 'desc'), 0, 100, array());

        return array(
            'all' => array($configurationAll, 2),
            'limit' => array($configurationLimit, 2),
            'search' => array($configurationSearch, 1),
            'order' => array($configurationAllOrder, 2),
        );
    }

    /**
     * Test remove workflow profile
     */
    public function testRemoveWorkflowProfile()
    {
        $dm = static::$kernel->getContainer()->get('object_manager');
        $validator = $this->repository->findOneBy(array('labels.en' => 'Validator'));
        $contributor = $this->repository->findOneBy(array('labels.en' => 'Contributor'));

        $workflowProfileIds = array($validator->geTId(), $contributor->getId());

        $this->repository->removeWorkflowProfiles($workflowProfileIds);
        $this->assertNull($this->repository->findOneBy(array('labels.en' => 'Validator')));
        $this->assertNull($this->repository->findOneBy(array('labels.en' => 'Contributor')));

        $dm->persist(clone $validator);
        $dm->persist(clone $contributor);
        $dm->flush();
    }
}
