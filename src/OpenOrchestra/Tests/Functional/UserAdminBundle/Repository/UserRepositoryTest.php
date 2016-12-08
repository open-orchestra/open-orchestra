<?php

namespace OpenOrchestra\FunctionalTests\UserAdminBundle\Repository;

use OpenOrchestra\BaseBundle\Tests\AbstractTest\AbstractKernelTestCase;
use OpenOrchestra\Pagination\Configuration\PaginateFinderConfiguration;
use OpenOrchestra\UserBundle\Repository\UserRepository;

/**
 * Class UserRepositoryTest
 *
 * @group integrationTest
 */
class UserRepositoryTest extends AbstractKernelTestCase
{
    /**
     * @var UserRepository
     */
    protected $repository;

    /**
     * Set up test
     */
    protected function setUp()
    {
        parent::setUp();

        static::bootKernel();
        $this->repository = static::$kernel->getContainer()->get('open_orchestra_user.repository.user');
    }

    /**
     * @param PaginateFinderConfiguration  $configuration
     * @param int                          $count
     *
     * @dataProvider providePaginateAndSearch
     */
    public function testFindForPaginate(PaginateFinderConfiguration $configuration, $count)
    {
        $users = $this->repository->findForPaginate($configuration);
        $this->assertCount($count, $users);
    }

    /**
     * @return array
     */
    public function providePaginateAndSearch()
    {
        $configurationAll = PaginateFinderConfiguration::generateFromVariable(array(), 0, 100, array());
        $configurationLimit = PaginateFinderConfiguration::generateFromVariable(array(), 0, 1, array());
        $configurationSearch = PaginateFinderConfiguration::generateFromVariable(array(), 0, 100, array(), array('search' => 'demo'));
        $configurationAllOrder = PaginateFinderConfiguration::generateFromVariable(array('username' => 'desc'), 0, 100, array());

        return array(
            'all' => array($configurationAll, 5),
            'limit' => array($configurationLimit, 1),
            'search' => array($configurationSearch, 2),
            'order' => array($configurationAllOrder, 5),
        );
    }

    /**
     * @param PaginateFinderConfiguration  $configuration
     * @param array                        $sitesId
     * @param int                          $count
     *
     * @dataProvider providePaginateAndSearchWithSitesId
     */
    public function testPaginateAndSearchWithSitesId(PaginateFinderConfiguration $configuration, array $sitesId, $count)
    {
        $sitesId = $this->convertSiteIdInMongoId($sitesId);
        $users = $this->repository->findForPaginateFilterBySiteIds($configuration, $sitesId);
        $this->assertCount($count, $users);
    }

    /**
     * @return array
     */
    public function providePaginateAndSearchWithSitesId()
    {
        $configurationAll = PaginateFinderConfiguration::generateFromVariable(array(), 0, 100, array());
        $configurationLimit = PaginateFinderConfiguration::generateFromVariable(array(), 0, 1, array());
        $configurationSearch = PaginateFinderConfiguration::generateFromVariable(array(), 0, 100, array(), array('search' => 'admin'));
        $configurationAllOrder = PaginateFinderConfiguration::generateFromVariable(array('username' => 'desc'), 0, 100, array());

        return array(
            array($configurationAll, array(), 0),
            array($configurationAll, array('2'), 2),
            array($configurationLimit, array('2'), 1),
            array($configurationAllOrder, array('2'), 2),
            array($configurationSearch, array('2'), 2),
        );
    }

    /**
     * test count all user
     */
    public function testCount()
    {
        $users = $this->repository->count();
        $this->assertEquals(5, $users);
    }

    /**
     * test count all filter with site id
     */
    public function testCountFilterBySiteId()
    {
        $sitesId = $this->convertSiteIdInMongoId(array('2'));
        $users = $this->repository->countFilterBySiteIds($sitesId);
        $this->assertEquals(2, $users);
    }

    /**
     * @param PaginateFinderConfiguration $configuration
     * @param int                         $count
     *
     * @dataProvider provideCountWithFilter
     */
    public function testCountWithFilter($configuration, $count)
    {
        $users = $this->repository->countWithFilter($configuration);
        $this->assertEquals($count, $users);
    }

    /**
     * @return array
     */
    public function provideCountWithFilter()
    {
        $configurationAll = PaginateFinderConfiguration::generateFromVariable(array(), 0, 100, array());
        $configurationLimit = PaginateFinderConfiguration::generateFromVariable(array(), 0, 1, array());
        $configurationSearch = PaginateFinderConfiguration::generateFromVariable(array(), 0, 100, array(), array('search' => 'demo'));
        $configurationAllOrder = PaginateFinderConfiguration::generateFromVariable(array('username' => 'desc'), 0, 100, array());

        return array(
            'all' => array($configurationAll, 5),
            'limit' => array($configurationLimit, 5),
            'search' => array($configurationSearch, 2),
            'order' => array($configurationAllOrder, 5),
        );
    }

    /**
     * @param PaginateFinderConfiguration $configuration
     * @param array                       $sitesId
     * @param int                         $count
     *
     * @dataProvider provideCountWithFilterAndSitesId
     */
    public function testCountWithFilterAndSitesId($configuration, array $sitesId, $count)
    {
        $sitesId = $this->convertSiteIdInMongoId($sitesId);
        $users = $this->repository->countWithFilterAndSiteIds($configuration, $sitesId);
        $this->assertEquals($count, $users);
    }

    /**
     * @return array
     */
    public function provideCountWithFilterAndSitesId()
    {
        $configurationAll = PaginateFinderConfiguration::generateFromVariable(array(), 0, 100, array());
        $configurationLimit = PaginateFinderConfiguration::generateFromVariable(array(), 0, 1, array());
        $configurationSearch = PaginateFinderConfiguration::generateFromVariable(array(), 0, 100, array(), array('search' => 'admin'));
        $configurationAllOrder = PaginateFinderConfiguration::generateFromVariable(array('username' => 'desc'), 0, 100, array());

        return array(
            array($configurationAll, array(), 0),
            array($configurationAll, array('2'), 2),
            array($configurationLimit, array('2'), 2),
            array($configurationAllOrder, array('2'), 2),
            array($configurationSearch, array('2'), 2),
        );
    }

    /**
     * @param $username
     * @param $groupName
     * @param $countUser
     *
     * @dataProvider provideUserAndGroup
     */
    public function testFindByIncludedUsernameWithoutGroup($username, $groupName, $countUser)
    {
        $group =  static::$kernel->getContainer()->get('open_orchestra_user.repository.group')->findOneByName($groupName);
        $users = $this->repository->findByIncludedUsernameWithoutGroup($username, $group);

        $this->assertCount($countUser, $users);
    }

    public function provideUserAndGroup()
    {
        return array(
            array('de', 'Empty group', 1),
            array('admi', 'Empty group', 2),
            array('user', 'Empty group', 1),
            array('fakeUser', 'Demo group', 0)
        );
    }

    /**
     * Test remove users
     */
    public function testRemoveUsers()
    {
        $dm = static::$kernel->getContainer()->get('object_manager');
        $userDemo = $this->repository->findOneByUsername('demo');
        $userSAdmin = $this->repository->findOneByUsername('s-admin');

        $userIds = array($userDemo->geTId(), $userSAdmin->getId());

        $this->repository->removeUsers($userIds);
        $this->assertNull($this->repository->findOneByUsername('demo'));
        $this->assertNull($this->repository->findOneByUsername('s-admin'));

        $dm->persist(clone $userDemo);
        $dm->persist(clone $userSAdmin);
        $dm->flush();
    }

    /**
     * @param array $sitesId
     *
     * @return array
     */
    protected function convertSiteIdInMongoId(array $sitesId)
    {
        $sitesMongoId = array();

        foreach ($sitesId as $siteId) {
            $sitesMongoId[] = static::$kernel->getContainer()->get('open_orchestra_model.repository.site')->findOneBySiteId($siteId)->getId();
        }

        return $sitesMongoId;
    }
}
