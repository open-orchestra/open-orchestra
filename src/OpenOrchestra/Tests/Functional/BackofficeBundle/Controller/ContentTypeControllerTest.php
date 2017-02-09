<?php

namespace OpenOrchestra\FunctionalTests\BackofficeBundle\Controller;

use OpenOrchestra\FunctionalTests\Utils\AbstractFormTest;
use OpenOrchestra\ModelInterface\Repository\ContentTypeRepositoryInterface;

/**
 * Class ContentTypeControllerTest
 *
 * @group backofficeTest
 */
class ContentTypeControllerTest extends AbstractFormTest
{
    /**
     * @var ContentTypeRepositoryInterface
     */
    protected $contentTypeRepository;

    protected $username = 'developer';
    protected $password = 'developer';

    /**
     * Set up the test
     */
    public function setUp()
    {
        parent::setUp();
        $this->contentTypeRepository = static::$kernel->getContainer()->get('open_orchestra_model.repository.content_type');
    }

    /**
     * Test content type versionnning
     */
    public function testFormController()
    {
//         $contentTypes = $this->contentTypeRepository->findAll();
//         $contentTypeCount = count($contentTypes);

//         $crawler = $this->client->request('GET', '/admin/content-type/form/news');
//         $form = $crawler->selectButton('Save')->form();

//         $this->submitForm($form);

//         $contentTypes = $this->contentTypeRepository->findAll();
//         $this->assertCount($contentTypeCount + 1, $contentTypes);
    }

    /**
     * Test content edition
     */
    public function testEditContent()
    {
        $url = '/admin/content/form/notre_vision/fr';
        $crawler = $this->client->request('GET', $url);
        $this->assertNotContains('has-error', $this->client->getResponse()->getContent());
        $contentForm = $crawler->selectButton('Save')->form();
        $this->submitForm($contentForm);
        $this->assertContains('alert alert-success', $this->client->getResponse()->getContent());

        $crawler = $this->client->request('GET', '/admin/content-type/form/news');
        $form = $crawler->selectButton('Save')->form();

        $this->submitForm($form);

        $url = '/admin/content/form/notre_vision/fr';
        $this->client->request('GET', $url);
        $this->assertNotContains('has-error', $this->client->getResponse()->getContent());
    }

    /**
     * Test new content
     */
    public function testNewContent()
    {
        $url = '/admin/content/new/news/en';
        $this->client->request('GET', $url);
        $this->assertNotContains('has-error', $this->client->getResponse()->getContent());
    }
}
