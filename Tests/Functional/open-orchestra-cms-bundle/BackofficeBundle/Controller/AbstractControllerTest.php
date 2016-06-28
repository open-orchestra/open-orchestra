<?php

namespace OpenOrchestra\BackofficeBundle\Tests\Functional\Controller;

use OpenOrchestra\BackofficeBundle\Tests\Functional\AbstractAuthentificatedTest;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AbstractControllerTest
 */
abstract class AbstractControllerTest extends AbstractAuthentificatedTest
{
    /**
     * @var Client
     */
    protected $client;
    protected $username = 'admin';
    protected $password = 'admin';

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
    }

    /**
     * @param Response $response
     */
    protected function assertForm(Response $response)
    {
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertRegExp('/form/', $response->getContent());
        $this->assertNotRegExp('/<html/', $response->getContent());
        $this->assertNotRegExp('/_username/', $response->getContent());
    }
}
