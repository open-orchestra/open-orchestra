<?php

namespace OpenOrchestra\FunctionalTests\ApiBundle\Controller;

use OpenOrchestra\FunctionalTests\Utils\AbstractAuthenticatedTest;
use OpenOrchestra\ModelInterface\Repository\ContentRepositoryInterface;
use OpenOrchestra\ModelInterface\Repository\StatusRepositoryInterface;

/**
 * Class ContentControllerTest
 */
class ContentControllerTest extends AbstractAuthenticatedTest
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
        parent::setUp();
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
        $this->markTestSkipped('To reactivate when API roles will be implemented');

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
            array('draft', false),
            array('pending', false),
            array('published', true),
        );
    }
}
