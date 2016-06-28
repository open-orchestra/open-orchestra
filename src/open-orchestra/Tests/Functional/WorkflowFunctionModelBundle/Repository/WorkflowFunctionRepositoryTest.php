<?php

namespace OpenOrchestra\WorkflowFunctionModelBundle\Tests\Functional\Repository;

use OpenOrchestra\BaseBundle\Tests\AbstractTest\AbstractKernelTestCase;
use OpenOrchestra\Pagination\Configuration\FinderConfiguration;
use OpenOrchestra\Pagination\Configuration\PaginateFinderConfiguration;
use OpenOrchestra\WorkflowFunction\Repository\WorkflowFunctionRepositoryInterface;

/**
 * Class WorkflowFunctionRepositoryTest
 *
 * @group integrationTest
 */
class WorkflowFunctionRepositoryTest extends AbstractKernelTestCase
{
    /**
     * @var WorkflowFunctionRepositoryInterface
     */
    protected $repository;

    /**
     * Set up test
     */
    protected function setUp()
    {
        parent::setUp();

        static::bootKernel();
        $this->repository = static::$kernel->getContainer()->get('open_orchestra_workflow_function.repository.workflow_function');
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
        $worflowFunctions = $this->repository->findForPaginate($configuration);
        $this->assertCount($count, $worflowFunctions);
    }

    /**
     * @return array
     */
    public function providePaginateAndSearch()
    {
        $descriptionEntity = $this->getDescriptionColumnEntity();

        return array(
            array($descriptionEntity, null, null, 0 ,5 , 2),
            array($descriptionEntity, $this->generateSearchProvider('validator'), null, 0 ,5 , 1),
            array($descriptionEntity, $this->generateSearchProvider('contributor'),  null, 0 ,5 , 1),
            array($descriptionEntity, $this->generateSearchProvider('fakeName'),  null, 0 ,5 , 0),
            array($descriptionEntity, $this->generateSearchProvider('', 'validator'), null, 0 ,5 , 1),
        );
    }

    /**
     * test count all workflow function
     */
    public function testCount()
    {
        $worflowFunctions = $this->repository->count();
        $this->assertEquals(2, $worflowFunctions);
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
        $worflowFunctions = $this->repository->countWithFilter($configuration);
        $this->assertEquals($count, $worflowFunctions);
    }

    /**
     * @return array
     */
    public function provideColumnsAndSearchAndCount()
    {
        $descriptionEntity = $this->getDescriptionColumnEntity();

        return array(
            array($descriptionEntity, null, 2),
            array($descriptionEntity, $this->generateSearchProvider('validator'), 1),
            array($descriptionEntity, $this->generateSearchProvider('contributor'), 1),
            array($descriptionEntity, $this->generateSearchProvider('fakeName'), 0),
            array($descriptionEntity, $this->generateSearchProvider('', 'validator'), 1),
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
            $search['columns'] = array('names' => $searchName);
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
            'names' => array('key' => 'name', 'field' => 'names', 'type' => 'translatedValue'),
        );
    }

}
