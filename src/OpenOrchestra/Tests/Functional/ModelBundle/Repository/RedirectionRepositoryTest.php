<?php

namespace OpenOrchestra\FunctionalTests\ModelBundle\Repository;

use OpenOrchestra\BaseBundle\Tests\AbstractTest\AbstractKernelTestCase;
use OpenOrchestra\ModelBundle\Repository\RedirectionRepository;

/**
 * Class RedirectionRepositoryTest
 */
class RedirectionRepositoryTest extends AbstractKernelTestCase
{
    /**
     * @var RedirectionRepository
     */
    protected $repository;

    /**
     * Set up test
     */
    protected function setUp()
    {
        parent::setUp();

        static::bootKernel();
        $this->repository = static::$kernel->getContainer()->get('open_orchestra_model.repository.redirection');
    }

    /**
     * @param string $siteId
     * @param int    $count
     *
     * @dataProvider provideSiteIdCount
     */
    public function testFindBySiteId($siteId, $count)
    {
        $this->assertCount($count, $this->repository->findBySiteId($siteId));
    }

    /**
     * @return array
     */
    public function provideSiteIdCount()
    {
        return array(
            array('2', 1),
            array('fake2', 0),
        );
    }
}
