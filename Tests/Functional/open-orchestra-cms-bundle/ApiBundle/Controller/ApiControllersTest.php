<?php

namespace OpenOrchestra\ApiBundle\Tests\Functional\Controller;

/**
 * Class ApiControllersTest
 *
 * @group apiFunctional
 */
class ApiControllersTest extends AbstractControllerTest
{
    /**
     * @param string $url
     *
     * @dataProvider provideApiUrl
     */
    public function testApi($url, $getParameter = '')
    {
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
            array('/api/node/transverse/show-or-create'),
            array('/api/node/fixture_page_community/show-or-create'),
            array('/api/node/fixture_page_community/show-or-create', '&language=en'),
            array('/api/node/list/not-published-by-author'),
            array('/api/node/list/by-author'),
            array('/api/content'),
            array('/api/content/list/by-author'),
            array('/api/content/list/not-published-by-author'),
            array('/api/content', '&content_type=news'),
            array('/api/content-type'),
            array('/api/site'),
            array('/api/theme'),
            array('/api/role'),
            array('/api/group'),
            array('/api/redirection'),
            array('/api/status'),
            array('/api/template/template_full'),
            array('/api/datatable/translation'),
            array('/api/trashcan/list'),
            array('/api/translation/tinymce'),
            array('/api/dashboard'),
            array('/api/template_flex/template_home_flex'),
        );
    }
}
