<?php

namespace OpenOrchestra\ApiBundle\Tests\Functional\Controller;

use OpenOrchestra\Backoffice\NavigationPanel\Strategies\TreeNodesPanelStrategy;
use OpenOrchestra\Backoffice\Model\ModelGroupRoleInterface;
use OpenOrchestra\Backoffice\Repository\GroupRepositoryInterface;
use OpenOrchestra\ModelInterface\Model\NodeInterface;

/**
 * Class NodeControllerAccessTest
 *
 * @group apiFunctional
 */
class NodeControllerAccessTest extends AbstractControllerTest
{
    /**
     * @var GroupRepositoryInterface
     */
    protected $groupRepository;

    protected $username = 'user1';
    protected $password = 'user1';

    /**
     * Set up the test
     */
    public function setUp()
    {
        $this->client = static::createClient();

        $crawler = $this->client->request('GET', '/login');

        $form = $crawler->selectButton('Log in')->form();
        $form['_username'] = $this->username;
        $form['_password'] = $this->password;

        $this->client->submit($form);

        $this->groupRepository = static::$kernel->getContainer()->get('open_orchestra_user.repository.group');
    }

    /**
     * Test cannot duplicate node
     */
    public function testDuplicateNodeAccessDenied()
    {
        $nodeId = 'fixture_page_community';
        $groupName = 'Demo group';

        $this->updateModelGroupRole($groupName, $nodeId, ModelGroupRoleInterface::ACCESS_DENIED, TreeNodesPanelStrategy::ROLE_ACCESS_UPDATE_NODE);

        $this->client->request('POST', '/api/node/' . $nodeId . '/duplicate?language=fr');
        $this->assertSame(403, $this->client->getResponse()->getStatusCode());
        $this->assertContains('open_orchestra_api.node.duplicate_not_granted', $this->client->getResponse()->getContent());

        $this->updateModelGroupRole($groupName, $nodeId, ModelGroupRoleInterface::ACCESS_INHERIT, TreeNodesPanelStrategy::ROLE_ACCESS_UPDATE_NODE);
    }

    /**
     * @param string $groupName
     * @param string $modelId
     * @param string $accessType
     * @param string $role
     */
    protected function updateModelGroupRole($groupName, $modelId, $accessType, $role)
    {
        $group = $this->groupRepository->findOneBy(array('name' => $groupName));
        $groupId = $group->getId();
        $this->client->request(
            'POST',
            '/api/group/' . $groupId,
            array(),
            array(),
            array(),
            json_encode(array('model_roles' => array(
                array(
                    'model_id' => $modelId,
                    'type' => NodeInterface::GROUP_ROLE_TYPE,
                    'access_type' => $accessType,
                    'name' => $role
                )
            )))
        );
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
    }
}
