<?php

namespace OpenOrchestra\FunctionalTests\BackOfficeBundle\Security;

use OpenOrchestra\BaseBundle\Tests\AbstractTest\AbstractWebTestCase;
use Symfony\Bundle\FrameworkBundle\Client;

/**
 * Class FormLoginTest
 */
class FormLoginTest extends AbstractWebTestCase
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
     * Test form login with valid user
     */
    public function testLoginWithValidUser()
    {
        $userName = 'admin';
        $password = 'admin';
        $crawler = $this->client->request('GET', '/login');

        $form = $crawler->selectButton('Log in')->form();
        $form['_username'] = $userName;
        $form['_password'] = $password;
        $this->client->submit($form);

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
        $user = $this->client->getContainer()->get('security.token_storage')->getToken()->getUser();
        $this->assertInstanceOf('OpenOrchestra\UserBundle\Model\UserInterface', $user);
        $this->assertEquals($user->getUserName(), $userName);
    }

    /**
     * Test form login with invalid user
     */
    public function testLoginWithInvalidUser()
    {
        $userName = 'invalidUserName';
        $password = 'invalidUserName';
        $crawler = $this->client->request('GET', '/login');

        $form = $crawler->selectButton('Log in')->form();
        $form['_username'] = $userName;
        $form['_password'] = $password;
        $this->client->submit($form);

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
        $token = $this->client->getContainer()->get('security.token_storage')->getToken();
        $this->assertNull($token);
    }
}
