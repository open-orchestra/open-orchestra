<?php

namespace OpenOrchestra\UserAdminBundle\Tests\Functional\Controller;

use OpenOrchestra\BackofficeBundle\Tests\Functional\Controller\AbstractControllerTest;
use OpenOrchestra\UserBundle\Repository\UserRepositoryInterface;

/**
 * Class FormUserSuperAdminControllersTest
 */
class FormUserSuperAdminControllersTest extends AbstractControllerTest
{
    /** @var  UserRepositoryInterface */
    protected $userRepository;

    /**
     * Set Up
     */
    public function setUp()
    {
        parent::setUp();
        $this->userRepository = $this->client->getContainer()->get('open_orchestra_user.repository.user');
    }

    /**
     * Test user form super admin
     */
    public function testFormWithUserSuperAdmin()
    {
        $user = $this->userRepository->findOneByUsername('admin');

        $this->client->request('GET', '/admin/user/form/'.$user->getId());

        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertRegExp('/This user is super admin, so it is impossible to select rights because he already has all the access/', $response->getContent());
    }

    /**
     * Test user form no super admin
     */
    public function testFormWithUserNoSuperAdmin()
    {
        $user = $this->userRepository->findOneByUsername('demo');

        $this->client->request('GET', '/admin/user/form/'.$user->getId());

        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotRegExp('/This user is super admin, so it is impossible to select rights because he already has all the access/', $response->getContent());
    }
}
