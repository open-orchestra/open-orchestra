<?php

namespace OpenOrchestra\FunctionalTests\ModelBundle\Repository;

use OpenOrchestra\BaseBundle\Tests\AbstractTest\AbstractKernelTestCase;
use OpenOrchestra\ModelInterface\Repository\ContentTypeRepositoryInterface;

/**
 * Class ContentTypeRepositoryTest
 *
 * @group integrationTest
 */
class ContentTypeRepositoryTest extends AbstractKernelTestCase
{
    /**
     * @var ContentTypeRepositoryInterface
     */
    protected $repository;

    /**
     * Set up the test
     */
    public function setUp()
    {
        parent::setUp();

        static::bootKernel();
        $this->repository = static::$kernel->getContainer()->get('open_orchestra_model.repository.content_type');
    }

    /**
     * @param string $contentType
     * @param int    $version
     *
     * @dataProvider provideContentTypeAndVersionNumber
     */
    public function testFindOneByContentTypeIdInLastVersion($contentType, $version)
    {
        $contentTypeElement = $this->repository->findOneByContentTypeIdInLastVersion($contentType);

        $this->assertEquals($version, $contentTypeElement->getVersion());
    }

    /**
     * @return array
     */
    public function provideContentTypeAndVersionNumber()
    {
        return array(
            array('car', 2),
            array('customer', 1),
        );
    }
}
