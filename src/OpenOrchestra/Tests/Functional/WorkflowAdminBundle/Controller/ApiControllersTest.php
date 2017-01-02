<?php

namespace OpenOrchestra\FunctionalTests\WorkflowAdminBundle\Controller;

use OpenOrchestra\FunctionalTests\Utils\AbstractAuthenticatedTest;

/**
 * Class ApiControllersTest
 *
 * @group apiFunctional
 */
class ApiControllersTest extends AbstractAuthenticatedTest
{
    /**
     * @param string $url
     * @param string $method
     *
     * @dataProvider provideApiUrl
     */
    public function testApi($url, $method = 'GET')
    {
        $this->client->request($method, $url . '?access_token=' . $this->getAccessToken());

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame('application/json', $this->client->getResponse()->headers->get('content-type'));
    }

    /**
     * @return array
     */
    public function provideApiUrl()
    {
        return array(
            array('/api/workflow-profile'),
            array('/api/workflow-profile/delete-multiple', 'DELETE'),
        );
    }
}
