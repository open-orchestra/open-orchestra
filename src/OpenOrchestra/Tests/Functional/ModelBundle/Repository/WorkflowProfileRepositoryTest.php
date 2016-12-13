<?php

namespace OpenOrchestra\FunctionalTests\ModelBundle\Repository;

use OpenOrchestra\BaseBundle\Tests\AbstractTest\AbstractKernelTestCase;

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
}
