<?php

namespace OpenOrchestra\FunctionalTests\ModelBundle\Repository;

use OpenOrchestra\BaseBundle\Tests\AbstractTest\AbstractKernelTestCase;
use OpenOrchestra\Pagination\Configuration\FinderConfiguration;
use OpenOrchestra\Pagination\Configuration\PaginateFinderConfiguration;
use Phake;
use OpenOrchestra\ModelInterface\Repository\ContentRepositoryInterface;
use OpenOrchestra\ModelInterface\Repository\RepositoryTrait\KeywordableTraitInterface;

/**
 * Class ContentRepositoryTest
 *
 * @group integrationTest
 */
class ContentRepositoryTest extends AbstractKernelTestCase
{
    /**
     * @var ContentRepositoryInterface
     */
    protected $repository;
    protected $keywordRepository;

    protected $currentsiteManager;

    /**
     * Set up test
     */
    protected function setUp()
    {
        parent::setUp();
        static::bootKernel();
        $this->keywordRepository = static::$kernel->getContainer()->get('open_orchestra_model.repository.keyword');
        $this->currentsiteManager = Phake::mock('OpenOrchestra\BaseBundle\Context\CurrentSiteIdInterface');
        Phake::when($this->currentsiteManager)->getCurrentSiteId()->thenReturn('2');
        Phake::when($this->currentsiteManager)->getCurrentSiteDefaultLanguage()->thenReturn('fr');

        $this->repository = static::$kernel->getContainer()->get('open_orchestra_model.repository.content');
    }

    /**
     * @param string  $name
     * @param boolean $exists
     *
     * @dataProvider provideTestUniquenessInContext
     */
    public function testTestUniquenessInContext($name, $exists)
    {
        $test = $this->repository->testUniquenessInContext($name);

        $this->assertEquals($exists, $test);

    }

    /**
     * @return array
     */
    public function provideTestUniquenessInContext()
    {
        return array(
            array('welcome', true),
            array('fakeContentId', false),
        );
    }

    /**
     * @param string $contentId
     *
     * @dataProvider provideFindOneByContentId
     */
    public function testFindOneByContentId($contentId)
    {
        $content = $this->repository->findOneByContentId($contentId);
        $this->assertSameContent(null, null, null, $contentId, $content);
        $this->assertEquals($contentId, $content->getContentId());
    }

    /**
     * @return array
     */
    public function provideFindOneByContentId()
    {
        return array(
            array('notre_vision'),
            array('bien_vivre_en_france'),
        );
    }

    /**
     * @param $contentId
     * @param $version
     * @param string|null $language
     *
     * @dataProvider providefindLastPublishedVersion
     */
    public function testFindLastPublishedVersion($contentId, $version, $language)
    {
        $content = $this->repository->findLastPublishedVersion($contentId, $language);
        $this->assertSameContent($language, $version, null, $contentId, $content);
        $this->assertEquals($contentId, $content->getContentId());
    }

    /**
     * @param $contentId
     * @param $version
     * @param string|null $language
     *
     * @dataProvider providefindLastPublishedVersion
     */
    public function testFindOneCurrentlyPublished($contentId, $version, $language)
    {
        $content = $this->repository->findOneCurrentlyPublished($contentId, $language, '2');
        $this->assertSameContent($language, $version, null, $contentId, $content);
        $this->assertEquals($contentId, $content->getContentId());
    }

    /**
     * @return array
     */
    public function providefindLastPublishedVersion()
    {
        return array(
            array('notre_vision', 1, 'fr'),
            array('bien_vivre_en_france', 1, 'fr'),
        );
    }

    /**
     * @param string      $contentType
     * @param string      $choiceType
     * @param string|null $keywords
     * @param int         $count
     *
     * @dataProvider provideContentTypeKeywordAndCount
     */
    public function testFindByContentTypeAndCondition($contentType = '', $choiceType, $keywords = null, $count)
    {
        $keywords = $this->replaceKeywordLabelById($keywords);

        $language = $this->currentsiteManager->getCurrentSiteDefaultLanguage();
        $elements = $this->repository->findByContentTypeAndCondition($language, $contentType, $choiceType, $keywords);

        $this->assertCount($count, $elements);
    }

    /**
     * @return array
     */
    public function provideContentTypeKeywordAndCount()
    {
        return array(
            array('car', ContentRepositoryInterface::CHOICE_AND, 'lorem', 3),
            array('car',ContentRepositoryInterface::CHOICE_AND, 'sit', 1),
            array('car', ContentRepositoryInterface::CHOICE_AND, 'dolor', 0),
            array('car', ContentRepositoryInterface::CHOICE_AND, 'sit AND lorem', 1),
            array('news', ContentRepositoryInterface::CHOICE_AND, 'lorem', 1),
            array('news', ContentRepositoryInterface::CHOICE_AND, 'sit', 2),
            array('news', ContentRepositoryInterface::CHOICE_AND, 'dolor', 0),
            array('news', ContentRepositoryInterface::CHOICE_AND, 'lorem AND sit', 1),
            array('news', ContentRepositoryInterface::CHOICE_AND, '', 4),
            array('car', ContentRepositoryInterface::CHOICE_AND, '', 3),
            array('', ContentRepositoryInterface::CHOICE_AND, '', 9),
            array('', ContentRepositoryInterface::CHOICE_AND, '', 9),
            array('', ContentRepositoryInterface::CHOICE_AND, 'lorem', 5),
            array('', ContentRepositoryInterface::CHOICE_AND, 'sit', 4),
            array('', ContentRepositoryInterface::CHOICE_AND, 'dolor', 0),
            array('', ContentRepositoryInterface::CHOICE_AND, 'lorem AND sit', 3),
            array('car', ContentRepositoryInterface::CHOICE_OR, 'lorem', 5),
            array('car', ContentRepositoryInterface::CHOICE_OR, 'sit', 6),
            array('car', ContentRepositoryInterface::CHOICE_OR, 'dolor', 3),
            array('car', ContentRepositoryInterface::CHOICE_OR, 'lorem AND sit', 5),
            array('news', ContentRepositoryInterface::CHOICE_OR, 'lorem', 8),
            array('news', ContentRepositoryInterface::CHOICE_OR, 'sit', 6),
            array('news', ContentRepositoryInterface::CHOICE_OR, 'dolor', 4),
            array('news', ContentRepositoryInterface::CHOICE_OR, 'lorem AND sit', 6),
            array('news', ContentRepositoryInterface::CHOICE_OR, '', 4),
            array('car', ContentRepositoryInterface::CHOICE_OR, '', 3),
            array('', ContentRepositoryInterface::CHOICE_OR, '', 9),
            array('', ContentRepositoryInterface::CHOICE_OR, 'lorem', 5),
            array('', ContentRepositoryInterface::CHOICE_OR, 'sit', 4),
            array('', ContentRepositoryInterface::CHOICE_OR, 'dolor', 0),
            array('', ContentRepositoryInterface::CHOICE_OR, 'lorem AND sit', 3),
            array('', ContentRepositoryInterface::CHOICE_OR, '', 9),
        );
    }

    /**
     * @param string $contentId
     * @param string $language
     *
     * @dataProvider provideFindOneByContentIdAndLanguage
     */
    public function testFindOneByLanguage($contentId, $language)
    {
        $content = $this->repository->findOneByLanguage($contentId, $language);

        $this->assertSameContent($language, null, null, $contentId, $content);
    }

    /**
     * @return array
     */
    public function provideFindOneByContentIdAndLanguage()
    {
        return array(
            array('notre_vision', 'fr'),
            array('bien_vivre_en_france', 'fr'),
        );
    }

    /**
     * @param string $contentId
     * @param string $language
     *
     * @dataProvider provideFindByContentIdAndLanguage
     */
    public function testFindByLanguage($contentId, $language)
    {
        $contents = $this->repository->findByLanguage($contentId, $language);

        foreach ($contents as $content) {
            $this->assertSameContent($language, null, null, $contentId, $content);
        }

    }

    /**
     * @return array
     */
    public function provideFindByContentIdAndLanguage()
    {
        return array(
            array('notre_vision', 'fr'),
            array('bien_vivre_en_france', 'fr'),
        );
    }

    /**
     * @param string $contentId
     * @param string $language
     * @param int    $version
     *
     * @dataProvider provideFindOneByContentIdAndLanguageAndVersion
     */
    public function testFindOneByLanguageAndVersion($contentId, $language, $version)
    {
        $content = $this->repository->findOneByLanguageAndVersion($contentId, $language, $version);

        $this->assertSameContent($language, $version, null, $contentId, $content);

    }

    /**
     * @return array
     */
    public function provideFindOneByContentIdAndLanguageAndVersion()
    {
        return array(
            array('notre_vision', 'fr', 1),
            array('bien_vivre_en_france', 'fr', 1),
        );
    }

    /**
     * @param string   $contentType
     * @param array    $descriptionEntity
     * @param array    $search
     * @param string   $siteId
     * @param int      $skip
     * @param int      $limit
     * @param integer  $count
     *
     * @dataProvider provideContentTypeAndPaginateAndSearchAndsiteId
     */
    public function testFindPaginatedLastVersionByContentTypeAndsite($contentType, $descriptionEntity, $search, $order, $siteId, $skip, $limit, $count, $name = null)
    {
        $configuration = PaginateFinderConfiguration::generateFromVariable($descriptionEntity, $search);
        $configuration->setPaginateConfiguration($order, $skip, $limit);
        $contents = $this->repository->findPaginatedLastVersionByContentTypeAndsite($contentType, $configuration, $siteId);

        if(!is_null($name)) {
            $this->assertEquals($name, $contents[0]->getName());
        }
        $this->assertCount($count, $contents);
    }

    /**
     * @return array
     */
    public function provideContentTypeAndPaginateAndSearchAndsiteId()
    {
        $descriptionEntity = $this->getDescriptionColumnEntity();

        return array(
            array('car', $descriptionEntity, null, array("name" => "name", "dir" => "asc"), null, 0 ,5 , 3, '206 3 portes en'),
            array('car', $descriptionEntity, null, array("name" => "name", "dir" => "desc"), null, 0 ,5 , 3, 'R5 3 portes en'),
            array('car', $descriptionEntity, null, array("name" => "attributes.car_name.string_value", "dir" => "asc"), null, 0 ,5 , 3, '206 3 portes en'),
            array('car', $descriptionEntity, null, array("name" => "attributes.car_name.string_value", "dir" => "desc"), null, 0 ,5 , 3, 'R5 3 portes en'),
            array('car', $descriptionEntity, null, null, null, 0 ,1 , 1),
            array('car', $descriptionEntity, $this->generateColumnsProvider(array('name' => '206')), null, null, 0 ,2 , 1),
            array('car', $descriptionEntity, $this->generateColumnsProvider(array('version' => '2')), null, null, 0 ,2 , 2),
            array('news', $descriptionEntity, null, null, null, 0 , 100, 4),
            array('news', $descriptionEntity, null, null, null, 50 , 100, 0),
            array('news', $descriptionEntity, $this->generateColumnsProvider(array('name' => 'news')), null, null, 0 , null, 0),
            array('car', $descriptionEntity, null, null, '2', 0 ,5 , 3),
            array('car', $descriptionEntity, $this->generateColumnsProvider(array('status_label' => 'publish')), null, null, null ,null , 3),
            array('car', $descriptionEntity, $this->generateColumnsProvider(array('status_label' => 'Publi')), null, null, null ,null , 3),
            array('car', $descriptionEntity, $this->generateColumnsProvider(array('status_label' => 'draft')), null, null, null ,null , 0),
            array('car', $descriptionEntity, $this->generateColumnsProvider(array('status_label' => 'brouillon')), null, null, null ,null , 0),

        );
    }

    /**
     * @param string  $contentType
     * @param integer $count
     *
     * @dataProvider provideContentTypeCount
     * @deprecated will be removed in 2.0, use countByContentTypeAndSiteInLastVersion
     */
    public function testCountByContentTypeInLastVersion($contentType, $count)
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.1.3 and will be removed in 2.0. Use the '.__CLASS__.'::countByContentTypeAndSiteInLastVersion method instead.', E_USER_DEPRECATED);
        $contents = $this->repository->countByContentTypeInLastVersion($contentType);
        $this->assertEquals($count, $contents);
    }

    /**
     * @return array
     */
    public function provideContentTypeCount()
    {
        return array(
            array('car', 3),
            array('customer', 2),
            array('news', 4),
        );
    }

    /**
     * @param string  $contentType
     * @param string  $siteId
     * @param integer $count
     *
     * @dataProvider provideCountByContentTypeAndSiteInLastVersion
     */
    public function testCountByContentTypeAndSiteInLastVersion($contentType, $siteId, $count)
    {
        $contents = $this->repository->countByContentTypeAndSiteInLastVersion($contentType, $siteId);
        $this->assertEquals($count, $contents);
    }

    /**
     * @return array
     */
    public function provideCountByContentTypeAndSiteInLastVersion()
    {
        return array(
            array('car', '1', 2),
            array('car', '2', 3),
            array('customer', '1', 1),
            array('customer', '2', 1),
            array('news', '1', 3),
            array('news', '2', 4),
        );
    }

    /**
     * @param string  $contentType
     * @param array   $descriptionEntity
     * @param string  $search
     * @param string  $siteId
     * @param int     $count
     *
     * @dataProvider provideColumnsAndSearchAndCount
     */
    public function testCountByContentTypeInLastVersionWithSearchFilter(
        $contentType,
        $descriptionEntity,
        $search,
        $siteId,
        $count
    ) {
        $configuration = FinderConfiguration::generateFromVariable($descriptionEntity, $search);
        $contents = $this->repository->countByContentTypeInLastVersionWithFilter($contentType, $configuration, $siteId);
        $this->assertEquals($count, $contents);
    }
    /**
     * @return array
     */
    public function provideColumnsAndSearchAndCount()
    {
        $descriptionEntity = $this->getDescriptionColumnEntity();
        return array(
            array('car', $descriptionEntity, $this->generateColumnsProvider(array('name' => '206')), '1', 1),
            array('car', $descriptionEntity, $this->generateColumnsProvider(array('name' => '206')), '2', 1),
            array('car', $descriptionEntity, $this->generateColumnsProvider(array('name' => 'DS 3')), '1', 0),
            array('car', $descriptionEntity, $this->generateColumnsProvider(array('name' => 'DS 3')), '2', 1),
            array('car', $descriptionEntity, $this->generateColumnsProvider(null, 'portes'), '1', 2),
            array('car', $descriptionEntity, $this->generateColumnsProvider(null, 'portes'), '2', 2),
            array('news', $descriptionEntity, $this->generateColumnsProvider(null, 'news'), '1', 0),
            array('news', $descriptionEntity, $this->generateColumnsProvider(null, 'news'), '2', 0),
            array('news', $descriptionEntity, $this->generateColumnsProvider(null, 'lorem'), '1', 1),
            array('news', $descriptionEntity, $this->generateColumnsProvider(null, 'lorem'), '2', 1),
        );
    }

    /**
     * @param string       $author
     * @param string       $siteId
     * @param boolean|null $published
     * @param int          $limit
     * @param array|null   $sort
     * @param int          $count
     *
     * @dataProvider provideFindByAuthorAndsiteId
     */
    public function testFindByAuthorAndsiteId($author, $siteId, $published, $limit, $sort, $count)
    {
        $contents = $this->repository->findByAuthorAndsiteId($author, $siteId, $published, $limit, $sort);
        $this->assertCount($count, $contents);
    }

    /**
     * @return array
     */
    public function provideFindByAuthorAndsiteId()
    {
        return array(
            array('admin', '2', null, 10, array('updatedAt' => -1), 8),
            array('admin', '2', false, 10, null, 0),
            array('admin', '2', true, 10, null, 8),
            array('fakeContributor', '2', false, 10, null, 0),
            array('fakeContributor', '2', null, 10, null, 0),
            array('admin', '3', true, 10, null, 7),
            array('admin', 'not-an-id', true, 10, null, 6),
            array('admin', 'not-an-id', true, 3, null, 3),
        );
    }

    /**
     * Generate columns of content with search value
     *
     * @param array|null $searchColumns
     * @param string     $globalSearch
     *
     * @return array
     */
    protected function generateColumnsProvider($searchColumns = null, $globalSearch = '')
    {
        $search = array();
        if (null !== $searchColumns) {
            $columns = array();
            foreach ($searchColumns as $name => $value) {
                $columns[$name] = $value;
            }
            $search['columns'] = $columns;
        }

        if (!empty($globalSearch)) {
            $search['global'] = $globalSearch;
        }

        return $search;
    }

    /**
     * Generate relation between columns names and entities attributes
     *
     * @return array
     */
    protected function getDescriptionColumnEntity()
    {
        return array (
            'name' =>
            array (
                'key' => 'name',
                'field' => 'name',
                'type' => 'string',
            ),
            'language' =>
            array (
                'key' => 'language',
                'field' => 'language',
                'type' => 'string',
            ),
            'status_label' =>
            array (
                'key' => 'status_label',
                'field' => 'status',
                'type' => 'multiLanguages',
            ),
            'version' =>
            array (
                'key' => 'version',
                'field' => 'version',
                'type' => 'integer',
            ),
            'linked_to_site' =>
            array (
                'key' => 'linked_to_site',
                'field' => 'linkedTosite',
                'type' => 'boolean',
            ),
            'created_by' =>
            array (
                'key' => 'created_by',
                'field' => 'createdBy',
                'type' => 'string',
            ),
            'updated_by' =>
            array (
                'key' => 'updated_by',
                'field' => 'updatedBy',
                'type' => 'string',
            ),
            'created_at' =>
            array (
                'key' => 'created_at',
                'field' => 'createdAt',
                'type' => 'date',
            ),
            'updated_at' =>
            array (
                'key' => 'updated_at',
                'field' => 'updatedAt',
                'type' => 'date',
            ),
            'deleted' =>
            array (
                'key' => 'deleted',
                'field' => 'deleted',
                'type' => 'boolean',
            ),
            'attributes.car_name.string_value' =>
            array(
                'key' => 'attributes.car_name.string_value',
                'field' => 'attributes.car_name.stringValue',
                'type' => 'string',
                'value' => NULL,
            ),
            'attributes.description.string_value' =>
            array(
                'key' => 'attributes.description.string_value',
                'field' => 'attributes.description.stringValue',
                'type' => 'string',
                'value' => NULL,
            ),
        );
    }

    /**
     * @param string                                               $language
     * @param int                                                  $version
     * @param string                                               $siteId
     * @param \OpenOrchestra\ModelInterface\Model\ContentInterface $content
     * @param string                                               $contentId
     */
    protected function assertSameContent($language, $version, $siteId, $contentId, $content)
    {
        $this->assertInstanceOf('OpenOrchestra\ModelInterface\Model\ContentInterface', $content);
        $this->assertSame($contentId, $content->getContentId());
        if (!is_null($language)) {
            $this->assertSame($language, $content->getLanguage());
        }
        if (!is_null($version)) {
            $this->assertSame($version, $content->getVersion());
        }
        if (!is_null($siteId)) {
            $this->assertSame($siteId, $content->getsiteId());
        }
        $this->assertSame(false, $content->isDeleted());
    }

    /**
     * Test has statused element
     */
    public function testHasStatusedElement()
    {
        $statusRepository = static::$kernel->getContainer()->get('open_orchestra_model.repository.status');
        $status = $statusRepository->findOneByInitial();

        $this->assertFalse($this->repository->hasStatusedElement($status));
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
