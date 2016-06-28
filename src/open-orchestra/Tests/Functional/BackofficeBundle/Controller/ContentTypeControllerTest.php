<?php

namespace OpenOrchestra\BackofficeBundle\Tests\Functional\Controller;

use OpenOrchestra\ModelInterface\Repository\ContentTypeRepositoryInterface;

/**
 * Class ContentTypeControllerTest
 *
 * @group backofficeTest
 */
class ContentTypeControllerTest extends AbstractControllerTest
{
    /**
     * @var ContentTypeRepositoryInterface
     */
    protected $contentTypeRepository;

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
        $this->markTestSkipped("Form submission broken by refacto on js error");

        $contentTypes = $this->contentTypeRepository->findAll();
        $contentTypeCount = count($contentTypes);

        $crawler = $this->client->request('GET', '/admin/content-type/form/news');
        $form = $crawler->selectButton('Save')->form();
        $this->client->submit($form);

        $contentTypes = $this->contentTypeRepository->findAll();
        $this->assertCount($contentTypeCount + 1, $contentTypes);
    }

    /**
     * Test content edition
     */
    public function testEditContent()
    {
        $this->markTestSkipped("Form submission broken by refacto on js error");

        $url = '/admin/content/form/welcome?language=fr';
        $crawler = $this->client->request('GET', $url);
        $this->assertNotContains('has-error', $this->client->getResponse()->getContent());
        $contentForm = $crawler->selectButton('Save')->form();
        $this->client->submit($contentForm);
        $this->assertContains('alert alert-success', $this->client->getResponse()->getContent());

        $crawler = $this->client->request('GET', '/admin/content-type/form/news');
        $form = $crawler->selectButton('Save')->form();
        $this->client->submit($form);

        $url = '/admin/content/form/welcome?language=fr';
        $crawler = $this->client->request('GET', $url);
        $this->assertNotContains('has-error', $this->client->getResponse()->getContent());
    }

    /**
     * Test new content
     */
    public function testNewContent()
    {
        $url = '/admin/content/new/news';
        $this->client->request('GET', $url);
        $this->assertNotContains('has-error', $this->client->getResponse()->getContent());
    }
}
