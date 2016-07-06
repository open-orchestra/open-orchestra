<?php

namespace OpenOrchestra\FunctionalTests\WorkflowFunctionAdminBundle\Controller;

use OpenOrchestra\FunctionalTests\Utils\AbstractAuthentificatedTest;

/**
 * Class ApiControllersSecurityTest
 *
 * @group securityCheck
 */
class ApiControllersSecurityTest extends AbstractAuthentificatedTest
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
            array('/api/workflow-function/root'),
            array('/api/workflow-function'),
            array('/api/workflow-function/root/delete', 'DELETE'),
        );
    }
}
