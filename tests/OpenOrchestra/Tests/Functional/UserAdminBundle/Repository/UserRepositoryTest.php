<?php

namespace OpenOrchestra\FunctionalTests\UserAdminBundle\Repository;

use OpenOrchestra\BaseBundle\Tests\AbstractTest\AbstractKernelTestCase;
use OpenOrchestra\Pagination\Configuration\PaginateFinderConfiguration;
use OpenOrchestra\UserBundle\Model\UserInterface;
use OpenOrchestra\UserBundle\Repository\UserRepository;
use OpenOrchestra\GroupBundle\Document\Group;

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
    protected $groupRepository;
    protected $language = 'en';

    /**
     * Set up test
     */
    protected function setUp()
    {
        parent::setUp();

        static::bootKernel();
        $this->repository = static::$kernel->getContainer()->get('open_orchestra_user.repository.user');
        $this->groupRepository = static::$kernel->getContainer()->get('open_orchestra_user.repository.group');
    }

    /**
     * @param PaginateFinderConfiguration  $configuration
     * @param int                          $count
     *
     * @dataProvider providePaginateAndSearch
     */
    public function testFindForPaginate(PaginateFinderConfiguration $configuration, $count)
    {
        $users = $this->repository->findForPaginate($configuration, $this->language);
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
        $users = $this->repository->findForPaginateFilterBySiteIds($configuration, $this->language, $sitesId);
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
        $users = $this->repository->countWithFilter($configuration, $this->language);
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
        $users = $this->repository->countWithFilterAndSiteIds($configuration, $this->language, $sitesId);
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
     * Test remove users
     */
    public function testGetCountsUsersByGroups()
    {
        $groupDemo = $this->groupRepository->findOneBy(array('labels.en' => 'Demo group'));
        $groupAdmin = $this->groupRepository->findOneBy(array('labels.en' => 'Site admin demo'));

        $groupIds = array($groupDemo->getId(), $groupAdmin->getId());

        $count = $this->repository->getCountsUsersByGroups($groupIds);
        $this->assertEquals(array($groupAdmin->getId() => 1, $groupDemo->getId() =>1), $count);
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

    /**
     * @param string $email
     *
     * @dataProvider provideEmail
     */
    public function testFindOneByEmail($email)
    {
        $user = $this->repository->findOneByEmail($email);
        $this->assertInstanceOf(UserInterface::class, $user);
        $this->assertEquals($user->getEmail(), $email);
    }

    /**
     * @return array
     */
    public function provideEmail()
    {
        return array(
            array('developer@fixtures.com'),
            array('p-admin@fixtures.com'),
            array('s-admin@fixtures.com'),
        );
    }

    /**
     * test findUsersByGroupsForPaginate
     */
    public function testFindUsersByGroupsForPaginate()
    {
        $configuration = PaginateFinderConfiguration::generateFromVariable(array(), 0, 100, array());
        $group = $this->groupRepository->findOneBy(array('labels.en' => 'Demo group'));
        $users = $this->repository->findUsersByGroupsForPaginate($configuration, $group->getId());
        $this->assertEquals(1, count($users));
    }

    /**
     * test countFilterByGroups
     */
    public function testCountFilterByGroups()
    {
        $group = $this->groupRepository->findOneBy(array('labels.en' => 'Demo group'));
        $this->assertEquals(1, $this->repository->countFilterByGroups($group->getId()));
    }

    /**
     * test removeGroupFromNotListedUsers
     */
    public function testRemoveGroupFromNotListedUsers()
    {
        $dm = static::$kernel->getContainer()->get('object_manager');

        $fakeGroup = new Group();
        $fakeGroup->setLabels(array('en' => 'fakeGroup'));
        $dm->persist($fakeGroup);
        $user = $this->repository->findOneByUsername('demo');
        $user->addGroup($fakeGroup);
        $dm->persist($user);

        $dm->flush();

        $group = $this->groupRepository->findOneBy(array('labels.en' => 'fakeGroup'));

        $this->assertEquals(1, $this->repository->countFilterByGroups($group->getId()));

        $this->repository->removeGroup($user->getId(), $group->getId());

        $this->assertEquals(0, $this->repository->countFilterByGroups($group->getId()));
    }

    /**
     * test addGroup
     */
    public function testAddGroup()
    {
        $dm = static::$kernel->getContainer()->get('object_manager');

        $fakeGroup = new Group();
        $fakeGroup->setLabels(array('en' => 'fakeGroup'));
        $dm->persist($fakeGroup);
        $dm->flush();

        $users = $this->repository->findAll();
        $nbrUsers = count($users);

        $this->repository->addGroup($users, $fakeGroup);
        $dm->flush();
        $this->assertEquals($nbrUsers, $this->repository->countFilterByGroups($fakeGroup->getId()));

        foreach ($users as $user) {
            $this->repository->removeGroup($user->getId(), $fakeGroup->getId());
        }

        $dm->flush();
        $this->assertEquals(0, $this->repository->countFilterByGroups($fakeGroup->getId()));

        $dm->remove($fakeGroup);
    }

}
