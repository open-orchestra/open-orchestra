<?php

namespace OpenOrchestra\FunctionalTests\WorkflowAdminBundle\Controller;

use OpenOrchestra\FunctionalTests\Utils\AbstractAuthenticatedTest;
use OpenOrchestra\ModelInterface\Repository\StatusRepositoryInterface;

/**
 * Class StatusControllerTest
 */
class StatusControllerTest extends AbstractAuthenticatedTest
{
    /**
     * @var StatusRepositoryInterface
     */
    protected $statusRepository;

    /**
     * Set up the test
     */
    public function setUp()
    {
        parent::setUp();
        $this->statusRepository = static::$kernel->getContainer()->get('open_orchestra_model.repository.status');
    }

    /**
     * Test cannot delete used status
     */
    public function testDeleteAction()
    {
        $status = $this->statusRepository->findOneByInitial();

        $this->client->request('DELETE', '/api/status/' . $status->getId() . '/delete');

        $this->assertSame(403, $this->client->getResponse()->getStatusCode());
        $this->assertContains('open_orchestra_workflow_admin.status.delete.impossible', $this->client->getResponse()->getContent());
    }
}
