<?php

namespace OpenOrchestra\FunctionalTests\UserAdminBundle\Controller;

use OpenOrchestra\FunctionalTests\BackofficeBundle\Controller\AbstractControllerTest;

/**
 * Class FormControllersTest
 */
class FormControllersTest extends AbstractControllerTest
{
    /**
     * Test user form
     */
    public function testForm()
    {
        $this->client->request('GET', '/admin/user/new');

        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertRegExp('/form/', $response->getContent());
        $this->assertNotRegExp('/<html/', $response->getContent());
        $this->assertRegExp('/registration_user/', $response->getContent());
    }
}
