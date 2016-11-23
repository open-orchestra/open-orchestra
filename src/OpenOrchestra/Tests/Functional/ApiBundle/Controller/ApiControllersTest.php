<?php

namespace OpenOrchestra\FunctionalTests\ApiBundle\Controller;

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
     * @param string $getParameter
     *
     * @dataProvider provideApiUrl
     */
    public function testApi($url, $getParameter = '')
    {
        $this->markTestSkipped();
        $baseGetParameter = '?access_token=' . $this->getAccessToken();
        $this->client->request('GET', $url . $baseGetParameter . $getParameter);
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame('application/json', $this->client->getResponse()->headers->get('content-type'));
    }

    /**
     * @return array
     */
    public function provideApiUrl()
    {
        return array(
            array('/api/node/root/show-or-create'),
            array('/api/node/root/show-or-create', '&language=en'),
            array('/api/node/fixture_page_community/show-or-create'),
            array('/api/node/fixture_page_community/show-or-create', '&language=en'),
            array('/api/node/list/not-published-by-author'),
            array('/api/node/list/by-author'),
            array('/api/node/list/2/fr'),
            array('/api/content'),
            array('/api/content/list/by-author'),
            array('/api/content/list/not-published-by-author'),
            array('/api/content', '&content_type=news'),
            array('/api/content-type'),
            array('/api/site'),
            array('/api/site/list/available'),
            array('/api/theme'),
            array('/api/role'),
            array('/api/group'),
            array('/api/redirection'),
            array('/api/status'),
            array('/api/status/list'),
            array('/api/datatable/translation'),
            array('/api/trashcan/list'),
            array('/api/translation/tinymce'),
        );
    }
}
