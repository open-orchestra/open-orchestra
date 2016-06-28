<?php

namespace OpenOrchestra\ApiBundle\Tests\Functional\Controller;

use OpenOrchestra\ModelInterface\Repository\StatusRepositoryInterface;

/**
 * Class StatusControllerTest
 */
class StatusControllerTest extends AbstractControllerTest
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
        $this->client = static::createClient();

        $crawler = $this->client->request('GET', '/login');

        $form = $crawler->selectButton('Log in')->form();
        $form['_username'] = $this->username;
        $form['_password'] = $this->password;

        $this->client->submit($form);

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
        $this->assertContains('open_orchestra_api.status.delete_not_granted', $this->client->getResponse()->getContent());
    }
}
