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
     * @param string  $toCriteria
     * @param string  $fromCriteria
     * @param boolean $expectedBool
     *
     * @dataProvider provideTransitions
     */
    public function testHasTransition($fromCriteria, $toCriteria, $expectedBool)
    {
        $statusFrom = $this->statusRepository->findOneBy($fromCriteria);
        $statusTo = $this->statusRepository->findOneBy($toCriteria);

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
            array(array('initial' => true), array('translationState' => true)                   , false),
            array(array('initial' => true), array('published' => true, 'blockedEdition' => true), true),
        );
    }
}
