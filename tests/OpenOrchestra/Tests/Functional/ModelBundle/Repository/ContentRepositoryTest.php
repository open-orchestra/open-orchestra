<?php

namespace OpenOrchestra\FunctionalTests\ModelBundle\Repository;

use OpenOrchestra\BaseBundle\Tests\AbstractTest\AbstractKernelTestCase;
use OpenOrchestra\Pagination\Configuration\PaginateFinderConfiguration;
use OpenOrchestra\ModelInterface\Repository\ContentRepositoryInterface;
use OpenOrchestra\ModelInterface\Repository\RepositoryTrait\KeywordableTraitInterface;
use OpenOrchestra\ModelInterface\ContentEvents;
use Phake;
use OpenOrchestra\ModelBundle\Document\ContentType;
use OpenOrchestra\ModelBundle\Document\Content;

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
    protected $userRepository;
    protected $statusRepository;
    protected $contentTypeRepository;

    protected $currentsiteManager;

    /**
     * Set up test
     */
    protected function setUp()
    {
        parent::setUp();
        static::bootKernel();
        $this->keywordRepository = static::$kernel->getContainer()->get('open_orchestra_model.repository.keyword');
        $this->userRepository = static::$kernel->getContainer()->get('open_orchestra_user.repository.user');
        $this->currentsiteManager = Phake::mock('OpenOrchestra\BaseBundle\Context\CurrentSiteIdInterface');
        Phake::when($this->currentsiteManager)->getCurrentSiteId()->thenReturn('2');
        Phake::when($this->currentsiteManager)->getCurrentSiteDefaultLanguage()->thenReturn('fr');

        $this->repository = static::$kernel->getContainer()->get('open_orchestra_model.repository.content');
        $this->statusRepository = static::$kernel->getContainer()->get('open_orchestra_model.repository.status');
        $this->contentTypeRepository = static::$kernel->getContainer()->get('open_orchestra_model.repository.content_type');
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
     * @dataProvider provideFindPublishedVersion
     */
    public function testFindPublishedVersion($contentId, $version, $language)
    {
        $content = $this->repository->findPublishedVersion($contentId, $language);
        $this->assertSameContent($language, $version, null, $contentId, $content);
        $this->assertEquals($contentId, $content->getContentId());
    }

    /**
     * @param $contentId
     * @param $version
     * @param string|null $language
     *
     * @dataProvider provideFindPublishedVersion
     */
    public function testFindOnePublished($contentId, $version, $language)
    {
        $content = $this->repository->findOnePublished($contentId, $language, '2');
        $this->assertSameContent($language, $version, null, $contentId, $content);
        $this->assertEquals($contentId, $content->getContentId());
    }

    /**
     * @return array
     */
    public function provideFindPublishedVersion()
    {
        return array(
            array('notre_vision', '1', 'fr'),
            array('bien_vivre_en_france', '1', 'fr'),
        );
    }

    /**
     * @param string $contentId
     * @param string $language
     * @param int    $count
     *
     * @dataProvider provideFindNotDeletedSortByUpdatedAt
     */
    public function testFindNotDeletedSortByUpdatedAt($contentId, $language, $count)
    {
        $contents = $this->repository->findNotDeletedSortByUpdatedAt($contentId, $language);
        $this->assertCount($count, $contents);
    }

    /**
     * @param string $contentId
     * @param string $language
     * @param int    $count
     *
     * @dataProvider provideFindNotDeletedSortByUpdatedAt
     */
    public function testCountNotDeletedByLanguage($contentId, $language, $count)
    {
        $countContents = $this->repository->countNotDeletedByLanguage($contentId, $language);
        $this->assertSame($count, $countContents);
    }

    /**
     * @return array
     */
    public function provideFindNotDeletedSortByUpdatedAt()
    {
        return array(
            array('notre_vision', 'fr', 1),
            array('bien_vivre_en_france', 'fr', 1),
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
            array('notre_vision', 'fr', '1'),
            array('bien_vivre_en_france', 'fr', '1'),
        );
    }

    /**
     * @param string     $contentType
     * @param array|null $search
     * @param array|null $order
     * @param string     $siteId
     * @param int        $skip
     * @param int        $limit
     * @param string     $language
     * @param integer    $count
     * @param integer    $totalCount
     * @param string     $name
     *
     * @dataProvider provideContentTypeAndPaginateAndSearchAndsiteId
     */
    public function testFindForPaginateFilterByContentTypeSiteAndLanguage($contentType, $search, $order, $siteId, $skip, $limit, $language, $count, $totalCount, $name = null)
    {
        $mapping = array(
            'name' => 'name',
            'status_label' => 'status.labels.'.$language,
            'linked_to_site' => 'linkedToSite',
            'created_at' => 'createdAt',
            'created_by' => 'createdBy',
            'updated_at' => 'updatedAt',
            'updated_by' => 'updatedBy',
            'fields.car_name.string_value' => 'attributes.car_name.stringValue',
            'fields.description.string_value' => 'attributes.description.stringValue',
            'fields.on_market.string_value' => 'attributes.on_market.stringValue',
            'fields.tinimce_test.string_value' => 'attributes.tinimce_test.stringValue',
        );

        $searchTypes = array (
            'attributes.car_name' => 'text',
            'attributes.description' => 'text',
            'attributes.on_market' => 'date',
            'attributes.tinimce_test' => 'text',
        );


        $configuration = PaginateFinderConfiguration::generateFromVariable($order, $skip, $limit, $mapping, $search);
        $contents = $this->repository->findForPaginateFilterByContentTypeSiteAndLanguage($configuration, $contentType, $siteId, $language, $searchTypes);
        $repositoryCount = $this->repository->countWithFilterAndContentTypeSiteAndLanguage($configuration, $contentType, $siteId, $language, $searchTypes);

        if(!is_null($name)) {
            $this->assertEquals($name, $contents[0]->getName());
        }
        $this->assertCount($count, $contents);
        $this->assertEquals($totalCount, $repositoryCount);
    }

    /**
     * @return array
     */
    public function provideContentTypeAndPaginateAndSearchAndsiteId()
    {
        return array(
            1  => array('car', null, array("name" => "name", "dir" => "asc"), '2', 0 ,5 , 'en', 3, 3, '206 3 portes en'),
            2  => array('car', null, array("name" => "name", "dir" => "desc"), '2', 0 ,5 , 'en', 3, 3, 'R5 3 portes en'),
            3  => array('car', null, array("name" => "fields.car_name.string_value", "dir" => "asc"), '2', 0 ,5 , 'en', 3, 3, '206 3 portes en'),
            4  => array('car', null, array("name" => "fields.car_name.string_value", "dir" => "desc"),'2', 0 ,5 , 'en', 3, 3, 'R5 3 portes en'),
            5  => array('car', null, null, null, 0 ,1 , 'en', 1, 2),
            6  => array('car', array('attributes.car_name' => '206'), null, '2', 0 , 2 , 'en', 1, 1),
            7  => array('news', null, null, '2', 0 , 100, 'fr', 4, 4),
            8  => array('news', null, null, '2', 50 , 100, 'en', 0, 0),
            9 => array('news', array('name' => 'news'), null, '2', 0 , null, 'fr', 0, 0),
            10 => array('car', null, null, '2', 0 ,5 , 'en', 3, 3),
        );
    }

    /**
     * @param string  $contentType
     * @param string  $siteId
     * @param string  $language
     * @param integer $count
     *
     * @dataProvider provideCountByContentTypeAndSiteInLastVersion
     */
    public function testCountFilterByContentTypeSiteAndLanguage($contentType, $siteId, $language, $count)
    {
        $contents = $this->repository->countFilterByContentTypeSiteAndLanguage($contentType, $siteId, $language);
        $this->assertEquals($count, $contents);
    }

    /**
     * @return array
     */
    public function provideCountByContentTypeAndSiteInLastVersion()
    {
        return array(
            array('car', '1', 'en', 2),
            array('car', '2', 'en', 3),
            array('customer', '1', 'en', 1),
            array('customer', '2', 'en', 1),
            array('news', '1', 'en', 0),
            array('news', '2', 'fr', 4),
        );
    }

    /**
     * @param string       $user
     * @param string       $siteId
     * @param array        $eventTypes
     * @param boolean|null $published
     * @param int          $limit
     * @param array|null   $sort
     * @param int          $count
     *
     * @dataProvider provideFindByHistoryAndSiteId
     */
    public function testFindByHistoryAndSiteId($user, $siteId, array $eventTypes, $published, $limit, $sort, $count)
    {
        $user = $this->userRepository->findOneByUsername($user);

        $contents = $this->repository->findByHistoryAndSiteId($user->getId(), $siteId, $eventTypes, $published, $limit, $sort);
        $this->assertCount($count, $contents);
    }

    /**
     * @return array
     */
    public function provideFindByHistoryAndSiteId()
    {
        return array(
            1 => array('p-admin', '2', array(ContentEvents::CONTENT_CREATION), null, 10, array('updatedAt' => -1), 0),
            2 => array('p-admin', '2', array(ContentEvents::CONTENT_CREATION), false, 10, null, 0),
            3 => array('p-admin', '2', array(ContentEvents::CONTENT_CREATION), true, 10, null, 0),
            4 => array('p-admin', '2', array(ContentEvents::CONTENT_UPDATE), true, 10, null, 0),
            5 => array('p-admin', '2', array(ContentEvents::CONTENT_CREATION, ContentEvents::CONTENT_UPDATE), true, 10, null, 0),
        );
    }

    /**
     * test updateStatusByContentType
     */
    public function testUpdateStatusByContentType()
    {
        $contentTypeId = 'test';

        $outOfWorkflow = $this->statusRepository->findOneByOutOfWorkflow();

        $dm = $this->contentTypeRepository->getDocumentManager();

        $contentType = new ContentType();
        $contentType->setContentTypeId($contentTypeId);
        $dm->persist($contentType);
        $dm->flush();

        $content = new Content();
        $content->setContentType($contentTypeId);
        $dm->persist($content);
        $dm->flush();

        $this->repository->updateStatusByContentType($outOfWorkflow, $contentTypeId);
        $dm->clear();

        $updatedContent = $this->repository->findOneBy(array('_id' => $content->getId()));
        $this->assertEquals('outOfWorkflow', $updatedContent->getStatus()->getName());

        $contentType = $this->contentTypeRepository->findOneBy(array('contentTypeId' => $contentTypeId));

        $dm->remove($updatedContent);
        $dm->remove($contentType);
        $dm->flush();
    }

    /**
     * Test remove content version
     */
    public function testRemoveVersion()
    {
        $dm = static::$kernel->getContainer()->get('object_manager');
        $content = $this->repository->findOneByLanguageAndVersion('bien_vivre_en_france', 'fr', "1");
        $storageIds = array($content->geTId());
        $dm->detach($content);

        $this->repository->removeContentVersion($storageIds);
        $this->assertNull($this->repository->findOneByLanguageAndVersion('bien_vivre_en_france', 'fr', "1"));

        $dm->persist($content);
        $dm->flush();
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

        $this->assertTrue($this->repository->hasStatusedElement($status));
    }

    /**
     * Test findAllPublishedByContentId
     */
    public function findAllPublishedByContentId()
    {
        $contents = $this->repository->findAllPublishedByContentId('bien_vivre_en_france');

        $this->assertEquals(1, count($contents));
    }

    /**
     * Test findElementToAutoPublish
     */
    public function testFindElementToAutoPublish()
    {
        $fromStatus = $this->statusRepository->findByAutoPublishFrom();
        $contents = $this->repository->findElementToAutoPublish('2', $fromStatus);

        $this->assertEquals(0, count($contents));
    }

    /**
     * Test findElementToAutoUnpublish
     */
    public function testFindElementToAutoUnpublish()
    {
        $publishedStatus = $this->statusRepository->findOneByPublished();
        $contents = $this->repository->findElementToAutoUnpublish('2', $publishedStatus);

        $this->assertEquals(0, count($contents));
    }

    /**
     * Test find last version
     */
    public function testFindLastVersion()
    {
        $documentManager = static::$kernel->getContainer()->get('object_manager');
        $contentId = 'test-find-last-version';

        $firstContent = new Content();
        $firstContent->setCreatedAt(new \DateTime('2017-02-27T15:03:01.012345Z'));
        $firstContent->setContentId($contentId);
        $firstContent->setContentType('car');
        $documentManager->persist($firstContent);

        $lastContent = new Content();
        $lastContent->setCreatedAt(new \DateTime('2017-02-28T15:03:01.012345Z'));
        $lastContent->setContentId($contentId);
        $lastContent->setContentType('car');
        $documentManager->persist($lastContent);

        $documentManager->flush();

        $content = $this->repository->findLastVersion($contentId);
        $this->assertEquals((new \DateTime('2017-02-28T15:03:01.012345Z'))->getTimestamp(), $content->getCreatedAt()->getTimestamp());

        $documentManager->remove($firstContent);
        $documentManager->remove($lastContent);

        $documentManager->flush();
    }

    /**
     * Test soft delete content
     */
    public function testSoftDeleteAndRestoreContent()
    {
        $contentId = 'bien_vivre_en_france';

        $this->repository->softDeleteContent($contentId);
        $contents = $this->repository->findByContentId($contentId);
        foreach ($contents as $content ) {
            $this->assertTrue($content->isDeleted());
        }
        $this->repository->restoreDeletedContent($contentId);

        $documentManager = static::$kernel->getContainer()->get('object_manager');
        $documentManager->clear();
        $documentManager->close();

        $contents = $this->repository->findByContentId($contentId);
        foreach ($contents as $content ) {
            $this->assertFalse($content->isDeleted());
        }
    }

    /**
     * @param string $contentId
     * @param bool   $has
     *
     * @dataProvider provideContentIdforHasContentNotOffline
     */
    public function testHasContentIdWithoutAutoUnpublishToState($contentId, $has)
    {
        $this->assertSame($has, $this->repository->hasContentIdWithoutAutoUnpublishToState($contentId));
    }

    /**
     * @return array
     */
    public function provideContentIdforHasContentNotOffline()
    {
        return array(
            array('bien_vivre_en_france', true),
            array('notre_vision', true)
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
     * Test update embedded status
     */
    public function testUpdateEmbeddedStatus()
    {
        $statusRepository = static::$kernel->getContainer()->get('open_orchestra_model.repository.status');
        $status = $statusRepository->findOneByName('published');
        $fakeColor = 'fakeColor';
        $saveColor = $status->getDisplayColor();
        $status->setDisplayColor($fakeColor);
        $this->repository->updateEmbeddedStatus($status);

        $content = $this->repository->findOnePublished('bien_vivre_en_france', 'fr', '2');
        $this->assertEquals($fakeColor, $content->getStatus()->getDisplayColor());

        $status->setDisplayColor($saveColor);
        $this->repository->updateEmbeddedStatus($status);
    }
}
