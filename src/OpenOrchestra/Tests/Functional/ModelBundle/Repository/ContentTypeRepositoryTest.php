<?php

namespace OpenOrchestra\FunctionalTests\ModelBundle\Repository;

use OpenOrchestra\BaseBundle\Tests\AbstractTest\AbstractKernelTestCase;
use OpenOrchestra\ModelInterface\Repository\ContentTypeRepositoryInterface;
use OpenOrchestra\Pagination\Configuration\PaginateFinderConfiguration;

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
            array('car', '2'),
            array('customer', '1'),
        );
    }

    /**
     * @param PaginateFinderConfiguration $configuration
     * @param int                         $count
     *
     * @dataProvider provideCountWithFilterAndLimit
     */
    public function testFindAllNotDeletedInLastVersionForPaginate(PaginateFinderConfiguration $configuration, $count)
    {
        $contentTypes = $this->repository->findAllNotDeletedInLastVersionForPaginate($configuration);

        $this->assertCount($count, $contentTypes);
    }

    /**
     * @return array
     */
    public function provideCountWithFilterAndLimit()
    {
        $configurationAll = PaginateFinderConfiguration::generateFromVariable(array(), 0, 100, array());
        $configurationLimit = PaginateFinderConfiguration::generateFromVariable(array(), 0, 1, array());
        $configurationSearch = PaginateFinderConfiguration::generateFromVariable(array(), 0, 100, array(), array('name' => 'car', 'language' => 'en'));
        $configurationAllOrder = PaginateFinderConfiguration::generateFromVariable(array('name' => 'desc'), 0, 100, array());

        return array(
            array($configurationAll, 3),
            array($configurationLimit, 1),
            array($configurationSearch, 1),
            array($configurationAllOrder, 3),
        );
    }

    /**
     * test count all contentType
     */
    public function testCount()
    {
        $contentTypes = $this->repository->countByContentTypeInLastVersion();

        $this->assertEquals(3, $contentTypes);
    }

    /**
     * @param PaginateFinderConfiguration $configuration
     * @param int                         $count
     *
     * @dataProvider provideCountWithFilter
     */
    public function testCountWithFilter($configuration, $count)
    {
        $sites = $this->repository->countNotDeletedInLastVersionWithSearchFilter($configuration);
        $this->assertEquals($count, $sites);
    }

    /**
     * @return array
     */
    public function provideCountWithFilter()
    {
        $configurationAll = PaginateFinderConfiguration::generateFromVariable(array(), 0, 100, array());
        $configurationSearch = PaginateFinderConfiguration::generateFromVariable(array(), 0, 100, array(), array('name' => 'car', 'language' => 'en'));
        $configurationAllOrder = PaginateFinderConfiguration::generateFromVariable(array('name' => 'desc'), 0, 100, array());

        return array(
            array($configurationAll, 3),
            array($configurationSearch, 1),
            array($configurationAllOrder, 3),
        );
    }

    /**
     * Test remove content types
     */
    public function testRemoveByContentTypeId()
    {
        $dm = static::$kernel->getContainer()->get('object_manager');
        $contentTypeCar = $this->repository->findOneByContentTypeIdInLastVersion('car');
        $contentTypeCustomer = $this->repository->findOneByContentTypeIdInLastVersion('customer');

        $userIds = array($contentTypeCar->getContentTypeId(), $contentTypeCustomer->getContentTypeId());
        $dm->detach($contentTypeCar);
        $dm->detach($contentTypeCustomer);

        $this->repository->removeByContentTypeId($userIds);
        $this->assertTrue($this->repository->findOneByContentTypeIdInLastVersion('car')->isDeleted());
        $this->assertTrue($this->repository->findOneByContentTypeIdInLastVersion('customer')->isDeleted());

        $contentTypeCar->setDeleted(false);
        $contentTypeCustomer->setDeleted(false);
        $dm->persist($contentTypeCar);
        $dm->persist($contentTypeCustomer);
        $dm->flush();
    }
}

