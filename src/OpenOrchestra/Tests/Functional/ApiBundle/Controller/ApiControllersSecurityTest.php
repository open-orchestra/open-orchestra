<?php

namespace OpenOrchestra\FunctionalTests\ApiBundle\Controller;

use OpenOrchestra\FunctionalTests\Utils\AbstractAuthenticatedTest;

/**
 * Class ApiControllersSecurityTest
 *
 * @group apiFunctional
 */
class ApiControllersSecurityTest extends AbstractAuthenticatedTest
{
    protected $username = "userNoAccess";
    protected $password = "userNoAccess";

    /**
     * @param string $url
     * @param string $method
     *
     * @dataProvider provideApiUrl
     */
    public function testApi($url, $method = 'GET')
    {
        $this->markTestSkipped('To reactivate when API roles will be implemented');

        $this->client->request($method, $url . '?access_token=' . $this->getAccessToken());
        $this->assertEquals(403, $this->client->getResponse()->getStatusCode());
    }

    /**
     * @return array
     */
    public function provideApiUrl()
    {
        return array(
            1  => array('/api/node/root'),
            2  => array('/api/node/root/show-or-create'),
            3  => array('/api/node/list/tree/2/fr'),
            4  => array('/api/node/root/delete', "DELETE"),
            5  => array('/api/node/root/children/update/order', 'PUT'),
            6  => array('/api/api-client'),
            7  => array('/api/api-client/root/delete', "DELETE"),
            8  => array('/api/content-type'),
            9  => array('/api/content-type/fake-content-type-id'),
            10 => array('/api/content-type/fake-content-type-id/delete', "DELETE"),
            11 => array('/api/site/root'),
            12 => array('/api/site'),
            13 => array('/api/site/root/delete', "DELETE"),
            14 => array('/api/keyword/check'),
            15 => array('/api/keyword/fake_id'),
            16 => array('/api/keyword/fake_id/delete', "DELETE"),
            17 => array('/api/keyword'),
            18 => array('/api/trashcan/list'),
            19 => array('/api/trashcan/fake_id/restore','PUT'),
            20 => array('/api/group/groupID/delete', "DELETE"),
            21 => array('/api/content'),
            22 => array('/api/content/root'),
            23 => array('/api/content/root/show-or-create'),
            24 => array('/api/content/root/delete', 'DELETE'),
            25 => array('/api/content/root/duplicate', "POST"),
            26 => array('/api/content/root/new-version', "POST"),
            27 => array('/api/content/root/update', 'POST'),
            28 => array('/api/content/root/list-statuses'),
            29 => array('/api/content/root/list-version'),
            30 => array('/api/redirection'),
            31 => array('/api/redirection/fake-id'),
            32 => array('/api/redirection/fake-id/delete', "DELETE"),
            33 => array('/api/status'),
            34 => array('/api/status/root/delete', 'DELETE'),
            35 => array('/api/role'),
            36 => array('/api/role/show/root'),
            37 => array('/api/role/type-node'),
            38 => array('/api/role/type/folder'),
            39 => array('/api/role/root/delete', 'DELETE'),
        );
    }
}
