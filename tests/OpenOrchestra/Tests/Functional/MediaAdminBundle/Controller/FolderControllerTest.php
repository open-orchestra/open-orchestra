<?php

namespace OpenOrchestra\FunctionalTests\MediaAdminBundle\Controller;

use OpenOrchestra\FunctionalTests\Utils\AbstractFormTest;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class FolderControllerTest
 *
 * @group media
 */
class FolderControllerTest extends AbstractFormTest
{
    /**
     * Test folder form
     */
    public function testMediaFolderFormAdmin()
    {
        $crawler = $this->getCrawler();
        $this->assertForm($this->client->getResponse());

        $form = $crawler->selectButton('Save')->form();

        $this->submitForm($form);
        $this->assertForm($this->client->getResponse());
    }

    /**
     * Test folder form with only create role
     */
    public function testMediaFolderFormUserWithCreateRole()
    {
        $this->username = 'demo';
        $this->password = 'demo';
        $this->logIn();

        $this->getCrawler();
        $this->assertContains("form-disabled", $this->client->getResponse()->getContent());
    }


    /**
     * @return Crawler $crawler
     */
    protected function getCrawler()
    {
        $mediaFolderRepository = static::$kernel->getContainer()->get('open_orchestra_media.repository.media_folder');
        $mediaFolder = $mediaFolderRepository->findOneByName('Images');

        $url = '/admin/folder/form/' . $mediaFolder->getId();
        $crawler = $this->client->request('GET', $url);

        return $crawler;
    }
}
