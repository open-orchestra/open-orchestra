<?php

namespace OpenOrchestra\BackofficeBundle\Tests\Functional\Manager;

use OpenOrchestra\Backoffice\Manager\ContentTypeManager;
use OpenOrchestra\BaseBundle\Tests\AbstractTest\AbstractKernelTestCase;
use OpenOrchestra\ModelInterface\Model\ContentTypeInterface;

/**
 * Class ContentTypeManagerTest
 *
 * @group integrationTest
 */
class ContentTypeManagerTest extends AbstractKernelTestCase
{
    /**
     * @var ContentTypeManager
     */
    protected $manager;

    protected $contentTypeRepository;

    /**
     * Set up the test
     */
    public function setUp()
    {
        static::bootKernel();
        $this->contentTypeRepository = static::$kernel->getContainer()->get('open_orchestra_model.repository.content_type');

        $this->manager = new ContentTypeManager(static::$kernel->getContainer()->getParameter('open_orchestra_model.document.content_type.class'));
    }

    /**
     * @param string $contentTypeId
     *
     * @dataProvider provideContentTypeId
     */
    public function testDuplicate($contentTypeId)
    {
        /** @var ContentTypeInterface $contentType */
        $contentType = $this->contentTypeRepository->findOneByContentTypeId($contentTypeId);

        /** @var ContentTypeInterface $newContentType */
        $newContentType = $this->manager->duplicate($contentType);

        $this->assertNull($newContentType->getId());
        $this->assertEquals($contentType->getVersion() + 1, $newContentType->getVersion());
        $this->assertCount($contentType->getNames()->count(), $newContentType->getNames());
        $this->assertSame($contentType->getName('fr'), $newContentType->getName('fr'));
        $this->assertSame($contentType->getName('en'), $newContentType->getName('en'));
        $this->assertCount($contentType->getFields()->count(), $newContentType->getFields());
        $this->assertCount($contentType->getFields()->first()->getLabels()->count(), $newContentType->getFields()->first()->getLabels());
        $this->assertSame($contentType->getFields()->first()->getLabel('fr'), $newContentType->getFields()->first()->getLabel('fr'));
    }

    /**
     * @return array
     */
    public function provideContentTypeId()
    {
        return array(
            array('news'),
            array('car'),
            array('customer'),
        );
    }
}
