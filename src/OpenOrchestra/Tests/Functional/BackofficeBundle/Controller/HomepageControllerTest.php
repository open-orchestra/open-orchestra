<?php

namespace OpenOrchestra\FunctionalTests\BackofficeBundle\Controller;

use OpenOrchestra\FunctionalTests\Utils\AbstractFormTest;

/**
 * Class HomepageControllerTest
 *
 * @group backofficeTest
 */
class HomepageControllerTest extends AbstractFormTest
{
    /**
     * Test fixture_home
     */
    public function testHomepageWithTree()
    {
        $crawler = $this->client->request('GET', '/admin/');

        $this->assertEquals(1, $crawler->filter('html:contains("Contribution")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Administration")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Orchestra ?")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Content")')->count());
        $this->assertEquals(1, $crawler->filter('a:contains("Orchestra ?")')->count());
        $this->assertEquals(1, $crawler->filter('a:contains("Community")')->count());
        $this->assertEquals(2, $crawler->filter('a:contains("News")')->count());
        $this->assertEquals(1, $crawler->filter('a:contains("Legal Notice")')->count());
        $this->assertEquals(1, $crawler->filter('a:contains("Home")')->count());
    }

    /**
     * test new Template
     */
    public function testNewTemplatePageHome()
    {
        $crawler = $this->client->request('GET', '/admin/');
        $nbLink = $crawler->filter('a')->count();

        $crawler = $this->client->request('GET', '/admin/template/new');

        $formUser = $crawler->selectButton('Save')->form();
        $formUser['oo_template[name]'] = 'template test ' . time();
        $this->submitForm($formUser);

        $crawler = $this->client->request('GET', '/admin/');

        $this->assertEquals($nbLink + 1, $crawler->filter('a')->count());
    }
}
