<?php

namespace OpenOrchestra\FunctionalTests\ApiBundle\Controller;

use OpenOrchestra\Backoffice\Repository\GroupRepositoryInterface;
use OpenOrchestra\FunctionalTests\Utils\AbstractAuthenticatedTest;

/**
 * Class NodeControllerAccessTest
 *
 * @group apiFunctional
 */
class NodeControllerAccessTest extends AbstractAuthenticatedTest
{
    /**
     * @var GroupRepositoryInterface
     */
    protected $groupRepository;

    protected $username = 'user1';
    protected $password = 'user1';

    /**
     * Set up the test
     */
    public function setUp()
    {
        parent::setUp();
        $this->groupRepository = static::$kernel->getContainer()->get('open_orchestra_user.repository.group');
    }

    /**
     * Test cannot new version node
     */
    public function testNewVersionNodeAccessDenied()
    {
        $this->markTestSkipped('To reactivate when API roles will be implemented');

        $nodeId = 'fixture_page_community';
        $groupName = 'Demo group';

        $this->client->request('POST', '/api/node/' . $nodeId . '/new-version?language=fr');
        $this->assertSame(403, $this->client->getResponse()->getStatusCode());
        $this->assertContains('open_orchestra_api.node.new_version_not_granted', $this->client->getResponse()->getContent());
    }

}
