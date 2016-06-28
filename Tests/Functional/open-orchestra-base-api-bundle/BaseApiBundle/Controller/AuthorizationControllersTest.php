<?php

namespace OpenOrchestra\BaseApiBundle\Tests\Functional\Controller;

use OpenOrchestra\BaseBundle\Tests\AbstractTest\AbstractWebTestCase;
use Symfony\Bundle\FrameworkBundle\Client;

/**
 * Class AuthorizationControllersTest
 *
 * @group apiFunctional
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
        $this->client->request('GET', '/oauth/access_token?grant_type=client_credentials', array(), array(), array('PHP_AUTH_USER' => 'test_key', 'PHP_AUTH_PW' => 'test_secret'));
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame('application/json', $this->client->getResponse()->headers->get('content-type'));
        $tokenReponse = json_decode($this->client->getResponse()->getContent(), true);
        $refreshToken = $tokenReponse['refresh_token'];

        $this->client->request('GET', '/oauth/access_token?grant_type=refresh_token&refresh_token=' . $refreshToken, array(), array(), array('PHP_AUTH_USER' => 'test_key', 'PHP_AUTH_PW' => 'test_secret'));
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame('application/json', $this->client->getResponse()->headers->get('content-type'));
    }
}
