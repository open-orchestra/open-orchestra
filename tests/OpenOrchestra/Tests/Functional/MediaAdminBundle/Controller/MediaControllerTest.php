<?php

namespace OpenOrchestra\FunctionalTests\MediaAdminBundle\Controller;

use OpenOrchestra\FunctionalTests\Utils\AbstractFormTest;

/**
 * Class MediaControllerTest
 *
 * @group media
 */
class MediaControllerTest extends AbstractFormTest
{
    protected $media;

    /**
     * Set up the test
     */
    public function setUp()
    {
        parent::setUp();

        $mediaRepository = static::$kernel->getContainer()->get('open_orchestra_media.repository.media');
        $this->media = $mediaRepository->findOneByName('logo Open-Orchestra');
    }

    /**
     * @param string $form
     */
    public function testMediaForms()
    {
        $url = '/admin/media/' . $this->media->getId();

        $this->client->request('GET', $url);

        $this->assertForm($this->client->getResponse());
    }
}
