<?php

namespace OpenOrchestra\FunctionalTests\ModelBundle\Repository;

use OpenOrchestra\BaseBundle\Tests\AbstractTest\AbstractKernelTestCase;
use OpenOrchestra\ModelBundle\Repository\StatusRepository;

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
        $this->assertCount(4, $statuses);
        foreach ($statuses as $status) {
            $this->assertFalse($status->isOutOfWorkflow());
        }
    }

    /**
     * test find other by translation state
     */
    public function testFindOtherByTranslationState()
    {
        $statuses = $this->repository->findOtherByTranslationState('toTranslate');
        $this->assertCount(0, $statuses);
    }

    /**
     * test find one by translation state
     */
    public function testFindOneByTranslationState()
    {
        $status = $this->repository->findOneByTranslationState();
        $this->assertTrue($status->isTranslationState());
    }
}
