<?php

namespace OpenOrchestra\FunctionalTests\MediaBundle\Repository;

use OpenOrchestra\BaseBundle\Tests\AbstractTest\AbstractKernelTestCase;
use OpenOrchestra\Media\DisplayMedia\Strategies\VideoStrategy;
use OpenOrchestra\Media\Repository\MediaRepositoryInterface;
use OpenOrchestra\MediaAdmin\FileAlternatives\Strategy\ImageStrategy;
use OpenOrchestra\ModelInterface\Repository\RepositoryTrait\KeywordableTraitInterface;
use OpenOrchestra\Pagination\Configuration\PaginateFinderConfiguration;

/**
 * Class MediaRepositoryTest
 *
 * @group integrationTest
 */
class MediaRepositoryTest extends AbstractKernelTestCase
{
    /**
     * @var MediaRepositoryInterface
     */
    protected $repository;
    protected $keywordRepository;

    /**
     * Set up test
     */
    protected function setUp()
    {
        parent::setUp();

        static::bootKernel();
        $this->keywordRepository = static::$kernel->getContainer()->get('open_orchestra_model.repository.keyword');
        $this->repository = static::$kernel->getContainer()->get('open_orchestra_media.repository.media');
    }

    /**
     * @param string $keywords
     * @param int    $count
     *
     * @dataProvider provideKeywordAndCount
     */
    public function testFindByKeywords($keywords, $count)
    {
        $keywords = $this->replaceKeywordLabelById($keywords);
        $keywords = $this->repository->findByKeywords($keywords);

        $this->assertCount($count, $keywords);
    }

    /**
     * @return array
     */
    public function provideKeywordAndCount()
    {
        return array(
            array('lorem', 5),
            array('sit', 0),
            array('dolor', 4),
            array('lorem OR dolor', 5),
        );
    }

    /**
     * @param string $condition
     *
     * @return array
     */
    protected function replaceKeywordLabelById($condition)
    {
        $conditionWithoutOperator = preg_replace(explode('|', KeywordableTraitInterface::OPERATOR_SPLIT), ' ', $condition);
        $conditionArray = explode(' ', $conditionWithoutOperator);

        foreach ($conditionArray as $keyword) {
            if ($keyword != '') {
                $keywordDocument = $this->keywordRepository->findOneByLabel($keyword);
                if (!is_null($keywordDocument)) {
                    $condition = str_replace($keyword, $keywordDocument->getId(), $condition);
                } else {
                    return '';
                }
            }
        }

        return $condition;
    }

    /**
     * test findForPaginate
     *
     * @param string                      $siteId
     * @param PaginateFinderConfiguration $configuration
     * @param int                         $expectedCount
     * @param int                         $expectedFilteredCount
     *
     * @dataProvider providePaginateConfiguration
     */
    public function testFindForPaginate($siteId, PaginateFinderConfiguration $configuration, $expectedCount, $expectedFilteredCount)
    {
        $this->assertCount($expectedCount, $this->repository->findForPaginate($configuration, $siteId));
    }

    /**
     * test count
     */
    public function testCount()
    {
        $this->assertSame(6, $this->repository->count('2'));
    }

    /**
     * test count with Filtertered
     */
    public function testCountFiltered()
    {
        $this->assertSame(1, $this->repository->count('2', 'pdf'));
        $this->assertSame(5, $this->repository->count('2', 'image'));
    }

    /**
     * test countWithFilter
     *
     * @param string                      $siteId
     * @param PaginateFinderConfiguration $configuration
     * @param int                         $expectedCount
     * @param int                         $expectedFilteredCount
     *
     * @dataProvider providePaginateConfiguration
     */
    public function testCountWithFilter($siteId, PaginateFinderConfiguration $configuration, $expectedCount, $expectedFilteredCount)
    {
        $this->assertSame($expectedFilteredCount, $this->repository->countWithFilter($configuration, $siteId));
    }

    /**
     * Provide PaginateFinderConfiguration
     *
     * @return array
     */
    public function providePaginateConfiguration()
    {
        $mapping =  array();
        $conf1 = PaginateFinderConfiguration::generateFromVariable(null , null, null, $mapping, null);
        $conf2 = PaginateFinderConfiguration::generateFromVariable(null , null, null, $mapping, array('label' => 'dolor', 'language' => 'en'));
        $conf3 = PaginateFinderConfiguration::generateFromVariable(null , null, null, $mapping, array('type' => 'pdf'));

        return array(
            'No criteria'       => array('2', $conf1, 6, 6),
            'Filtering "dolor"' => array('2', $conf2, 4, 4),
            'Filtering pdf'     => array('2', $conf3, 1, 1),
        );
    }

    /**
     * Test remove medias
     */
    public function testRemoveMedias()
    {
        $dm = static::$kernel->getContainer()->get('object_manager');
        $image01 = $this->repository->findOneByName('Image 01');
        $image02 = $this->repository->findOneByName('Image 02');

        $mediaIds = array($image01->getId(), $image02->getId());

        $this->repository->removeMedias($mediaIds);
        $this->assertNull($this->repository->findOneByName('Image 01'));
        $this->assertNull($this->repository->findOneByName('Image 02'));

        $dm->persist(clone $image01);
        $dm->persist(clone $image02);
        $dm->flush();
    }

    /**
     * test countByFolderId
     */
    public function testCountByFolderId()
    {
        $folderRepository = static::$kernel->getContainer()->get('open_orchestra_media.repository.media_folder');
        $folder = $folderRepository->findOneBy(array('folderId' => 'files'));
        $this->assertEquals(0, $this->repository->countByFolderId($folder->getId()));

        $folder = $folderRepository->findOneBy(array('folderId' => 'images'));
        $this->assertEquals(4, $this->repository->countByFolderId($folder->getId()));
    }

    /**
     * Test is media type of
     */
    public function testIsMediaTypeOf()
    {
        $image = $this->repository->findOneByName('logo Open-Orchestra');

        $this->assertEquals(true, $this->repository->isMediaTypeOf($image->getId(), ImageStrategy::MEDIA_TYPE));
        $this->assertEquals(false, $this->repository->isMediaTypeOf($image->getId(), VideoStrategy::MEDIA_TYPE));
    }
}
