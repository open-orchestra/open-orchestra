<?php

namespace OpenOrchestra\FunctionalTests\UserAdminBundle\Controller;

use OpenOrchestra\BaseBundle\Tests\AbstractTest\AbstractWebTestCase;
use Symfony\Bundle\FrameworkBundle\Client;

/**
 * Class AuthorizationControllersTest
 *
 * @group securityCheck
 */
class AuthorizationControllersTest extends AbstractWebTestCase
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * Set up the test
     */
    public function setUp()
    {
        $this->client = static::createClient();
    }

    /**
     * Test token creation and usage
     */
    public function testTokenCreation()
    {
        $headers = array(
            'PHP_AUTH_USER' => 'test_key',
            'PHP_AUTH_PW' => 'test_secret',
            'HTTP_username' => 'admin',
            'HTTP_password' => 'admin',
        );
        $this->client->request('GET', '/oauth/access_token?grant_type=password', array(), array(), $headers);
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame('application/json', $this->client->getResponse()->headers->get('content-type'));
    }
}
