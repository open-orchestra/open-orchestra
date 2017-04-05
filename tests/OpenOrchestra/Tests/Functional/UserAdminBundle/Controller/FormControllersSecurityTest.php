<?php

namespace OpenOrchestra\FunctionalTests\UserAdminBundle\Controller;

use OpenOrchestra\FunctionalTests\Utils\AbstractAuthenticatedTest;

/**
 * Class FormControllersSecurityTest
 *
 * @group securityCheck
 */
class FormControllersSecurityTest extends AbstractAuthenticatedTest
{
    protected $username = 'userNoAccess';
    protected $password = 'userNoAccess';

    /**
     * Test creation form
     */
    public function testCreateForm()
    {
        $this->client->request('GET', '/admin/user/new');
        $this->assertEquals(403, $this->client->getResponse()->getStatusCode());
    }

    /**
     * Test edition form
     */
    public function testEditForm()
    {
        $user = $this->client->getContainer()->get('open_orchestra_user.repository.user')->findOneByUsername('p-admin');
        $this->client->request('GET', '/admin/user/form/' . $user->getId());
        $this->assertEquals(403, $this->client->getResponse()->getStatusCode());
    }
}
