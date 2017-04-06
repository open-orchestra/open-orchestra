<?php

namespace OpenOrchestra\FunctionalTests\MediaBundle\Repository;

use OpenOrchestra\BaseBundle\Tests\AbstractTest\AbstractKernelTestCase;
use OpenOrchestra\Media\Repository\FolderRepositoryInterface;

/**
 * Class FolderRepositoryTest
 *
 * @group integrationTest
 */
class FolderRepositoryTest extends AbstractKernelTestCase
{
    /**
     * @var FolderRepositoryInterface
     */
    protected $repository;

    /**
     * Set up test
     */
    protected function setUp()
    {
        parent::setUp();

        static::bootKernel();
        $this->repository = static::$kernel->getContainer()->get('open_orchestra_media.repository.media_folder');
    }

    /**
     * test findFolderTree
     */
    public function testFindFolderTree()
    {
        $tree = $this->repository->findFolderTree('2');

        $this->assertTrue(is_array($tree));
        $this->assertSame(2, count($tree));
        $this->assertTree($tree[0], 2);
        $this->assertTree($tree[1], 1);
        $this->assertTree($tree[0]['children'][0], 1);
        $this->assertTree($tree[0]['children'][1], 0);
        $this->assertTree($tree[1]['children'][0], 0);
    }

    /**
     * @param mixed $tree
     * @param int   $childrenCount
     */
    protected function assertTree($tree, $childrenCount)
    {
        $this->assertTrue(is_array($tree));
        $this->assertArrayHasKey('folder', $tree);
        $this->assertArrayHasKey('children', $tree);
        $this->assertSame($childrenCount, count($tree['children']));
    }
}
