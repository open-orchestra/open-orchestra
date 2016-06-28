<?php

namespace OpenOrchestra\BackofficeBundle\Tests\Functional;

use OpenOrchestra\BaseBundle\Tests\AbstractTest\AbstractWebTestCase;
use Symfony\Bundle\FrameworkBundle\Client;

/**
 * Class AbstractAuthentificatedTest
 */
abstract class AbstractAuthentificatedTest extends AbstractWebTestCase
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
}
