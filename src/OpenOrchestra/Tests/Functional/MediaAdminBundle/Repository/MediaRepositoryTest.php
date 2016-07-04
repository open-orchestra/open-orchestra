<?php

namespace OpenOrchestra\FunctionalTests\MediaBundle\Repository;

use OpenOrchestra\BaseBundle\Tests\AbstractTest\AbstractKernelTestCase;
use OpenOrchestra\Media\Repository\MediaRepositoryInterface;
use OpenOrchestra\ModelInterface\Repository\RepositoryTrait\KeywordableTraitInterface;

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
}
