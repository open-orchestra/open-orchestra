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
     *
     * @dataProvider provideStatusName
     */
    public function testChangeContentStatus($name)
    {
        $content = $this->contentRepository->findOneByLanguageAndVersion('206_3_portes', 'fr', '2');
        $newStatus = $this->statusRepository->findOneByName($name);

        $content->setStatus($newStatus);
        $this->client->request(
            'PUT',
            '/api/content/update-status',
            array(),
            array(),
            array(),
            static::$kernel->getContainer()->get('jms_serializer')->serialize($content, 'json')
        );

        $this->assertSame(200, $this->client->getResponse()->getStatusCode());

        $newContent = $this->contentRepository->findOneByLanguageAndVersion('206_3_portes', 'fr', '2');
        $this->assertSame($name, $newContent->getStatus()->getName());
    }

    /**
     * @return array
     */
    public function provideStatusName()
    {
        return array(
            array('draft'),
            array('pending'),
            array('published'),
        );
    }
}
