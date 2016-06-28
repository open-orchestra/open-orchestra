<?php

namespace OpenOrchestra\MediaAdminBundle\Tests\Functional\Controller;

use OpenOrchestra\BackofficeBundle\Tests\Functional\Controller\AbstractControllerTest;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class FolderControllerTest
 *
 * @group media
 */
class FolderControllerTest extends AbstractControllerTest
{
    /**
     * Set up the test
     */
    public function setUp()
    {
        $this->client = static::createClient();
    }

    /**
     * Test folder form
     */
    public function testMediaFolderFormAdmin()
    {
        $this->markTestSkipped("Form submission broken by refacto on js error");

        $this->connect("admin", "admin");

        $crawler = $this->getCrawler();
        $this->assertForm($this->client->getResponse());

        $form = $crawler->selectButton('Save')->form();

        $this->client->submit($form);
        $this->assertForm($this->client->getResponse());
    }

    /**
     * Test folder form with only create role
     */
    public function testMediaFolderFormUserWithCreateRole()
    {
        $this->connect("userFolderCreate", "userFolderCreate");
        $this->getCrawler();
        $this->assertContains("form-disabled", $this->client->getResponse()->getContent());
    }

    /**
     * @param string $username
     * @param string $password
     */
    protected function connect($username, $password)
    {
        $crawler = $this->client->request('GET', '/login');

        $form = $crawler->selectButton('Log in')->form();
        $form['_username'] = $username;
        $form['_password'] = $password;

        $this->client->submit($form);
    }

    /**
     * @return Crawler $crawler
     */
    protected function getCrawler()
    {
        $mediaFolderRepository = static::$kernel->getContainer()->get('open_orchestra_media.repository.media_folder');
        $mediaFolder = $mediaFolderRepository->findOneByName('Images folder');

        $url = '/admin/folder/form/' . $mediaFolder->getId();
        $crawler = $this->client->request('GET', $url);

        return $crawler;
    }
}
