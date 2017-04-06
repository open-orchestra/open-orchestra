<?php

namespace OpenOrchestra\FunctionalTests\ModelBundle\Repository;

use OpenOrchestra\BaseBundle\Tests\AbstractTest\AbstractKernelTestCase;

/**
 * Class FieldAutoGenerableRepositoryInterfaceTest
 *
 * @group integrationTest
 */
class FieldAutoGenerableRepositoryInterfaceTest extends AbstractKernelTestCase
{
    /**
     * Set up test
     */
    protected function setUp()
    {
        parent::setUp();

        static::bootKernel();
    }

    /**
     * @param string $serviceName
     *
     * @dataProvider provideServiceName
     */
    public function testImplementFieldAutoGenerableRepositoryInterface($serviceName)
    {
        $repository = static::$kernel->getContainer()->get($serviceName);

        $this->assertInstanceOf('OpenOrchestra\ModelInterface\Repository\FieldAutoGenerableRepositoryInterface', $repository);
    }

    /**
     * @return array
     */
    public function provideServiceName()
    {
        return array(
            array('open_orchestra_model.repository.node'),
            array('open_orchestra_model.repository.content'),
        );
    }
}
