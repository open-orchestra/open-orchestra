<?php

namespace PHPOrchestraSite\Bundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/hello/Fabien');

        $this->assertFalse($crawler->filter('html:contains("Hello Fabien")')->count() > 0);
    }
}
