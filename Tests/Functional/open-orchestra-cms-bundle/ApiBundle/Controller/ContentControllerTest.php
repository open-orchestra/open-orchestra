<?php

namespace OpenOrchestra\ApiBundle\Tests\Functional\Controller;

use OpenOrchestra\ModelInterface\Repository\ContentRepositoryInterface;
use OpenOrchestra\ModelInterface\Repository\StatusRepositoryInterface;

/**
 * Class ContentControllerTest
 */
class ContentControllerTest extends AbstractControllerTest
{
    /**
     * @var StatusRepositoryInterface
     */
    protected $statusRepository;

    /**
     * @var ContentRepositoryInterface
     */
    protected $contentRepository;

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

        $this->contentRepository = static::$kernel->getContainer()->get('open_orchestra_model.repository.content');
        $this->statusRepository = static::$kernel->getContainer()->get('open_orchestra_model.repository.status');
    }

    /**
     * @param string $name
     * @param bool   $currentlyPublished
     *
     * @dataProvider provideStatusName
     */
    public function testChangeContentStatus($name, $currentlyPublished)
    {
        $content = $this->contentRepository->findOneByLanguageAndVersion('206_3_portes', 'fr', 2);
        $newStatus = $this->statusRepository->findOneByName($name);
        $newStatusId = $newStatus->getId();

        $this->client->request(
            'POST',
            '/api/content/' . $content->getId() . '/update',
            array(),
            array(),
            array(),
            json_encode(array('status_id' => $newStatusId))
        );

        $this->assertSame(200, $this->client->getResponse()->getStatusCode());

        $newcontent = $this->contentRepository->findOneByLanguageAndVersion('206_3_portes', 'fr', 2);
        $this->assertEquals($currentlyPublished, $newcontent->isCurrentlyPublished());
    }

    /**
     * @return array
     */
    public function provideStatusName()
    {
        return array(
            array('draft', true),
            array('pending', false),
            array('published', false),
        );
    }
}
