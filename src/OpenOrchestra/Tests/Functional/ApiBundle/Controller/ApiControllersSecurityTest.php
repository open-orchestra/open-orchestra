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
        $this->client->request($method, $url . '?access_token=' . $this->getAccessToken());
        $this->assertEquals(403, $this->client->getResponse()->getStatusCode());
    }

    /**
     * @return array
     */
    public function provideApiUrl()
    {
        return array(
            1  => array('/api/node/show/root/2/fr'),
            3  => array('/api/node/root/delete', "DELETE"),
            4  => array('/api/node/root/children/update/order', 'PUT'),
            5  => array('/api/block/list/shared/fr'),
            6  => array('/api/block/list/block-component'),
            8  => array('/api/content-type'),
            12 => array('/api/site'),
            17 => array('/api/keyword'),
            //18 => array('/api/trashcan/list'),
            //19 => array('/api/trashcan/fake_id/restore','PUT'),
            20 => array('/api/group/list'),
            21 => array('/api/group/user/list'),
            22 => array('/api/group/duplicate', "POST"),
            23 => array('/api/content/list/lorem_ipsum/2/fr'),
            24 => array('/api/content/duplicate', "POST"),
            25 => array('/api/content/lorem_ipsum/delete', "DELETE"),
            29 => array('/api/content/list-version/lorem_ipsum/fr'),
            30 => array('/api/redirection'),
            32 => array('/api/redirection/node/2/root/fr'),
            33 => array('/api/status'),
            35 => array('/api/content/new-version/r5_3_portes/fr/2', 'POST'),
            36 => array('/api/node/new-version/root/fr/1', 'POST'),
        );
    }
}
