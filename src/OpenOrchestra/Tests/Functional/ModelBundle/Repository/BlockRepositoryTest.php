<?php

namespace OpenOrchestra\FunctionalTests\ModelBundle\Repository;

use OpenOrchestra\BaseBundle\Tests\AbstractTest\AbstractKernelTestCase;
use OpenOrchestra\ModelBundle\Repository\BlockRepository;

/**
 * Class BlockRepositoryTest
 *
 * @group integrationTest
 */
class BlockRepositoryTest extends AbstractKernelTestCase
{
    /**
     * @var BlockRepository
     */
    protected $repository;

    /**
     * Set up test
     */
    protected function setUp()
    {
        parent::setUp();

        static::bootKernel();
        $this->repository = static::$kernel->getContainer()->get('open_orchestra_model.repository.block');
    }

    /**
     * @param int    $count
     * @param string $component
     * @param string $language
     * @param string $siteId
     *
     * @dataProvider provideLanguageAndVersionListAndSiteId
     */
    public function testFindTransverseBlock($count, $component, $language, $siteId)
    {
        $blocks = $this->repository->findTransverseBlock($component, $siteId, $language);
        $this->assertCount($count, $blocks);
    }

    /**
     * @return array
     */
    public function provideLanguageAndVersionListAndSiteId()
    {
        return array(
            array(0,'fake_component', 'en', '2'),
            array(2, 'tiny_mce_wysiwyg', 'fr', '2'),
            array(2, 'tiny_mce_wysiwyg', 'en', '2'),
            array(1, 'menu', 'en', '2'),
        );
    }
}
