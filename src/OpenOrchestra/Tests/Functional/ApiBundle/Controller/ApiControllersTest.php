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
        $this->markTestSkipped('To reactivate when API roles will be implemented');

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
            1  => array('/api/node/root/show-or-create'),
            2  => array('/api/node/root/show-or-create', '&language=en'),
            3  => array('/api/node/fixture_page_community/show-or-create'),
            4  => array('/api/node/fixture_page_community/show-or-create', '&language=en'),
            5  => array('/api/node/list/not-published-by-author'),
            6  => array('/api/node/list/by-author'),
            7  => array('/api/node/list/2/fr'),
            8  => array('/api/content'),
            9  => array('/api/content/list/by-author'),
            10 => array('/api/content/list/not-published-by-author'),
            11 => array('/api/content', '&content_type=news'),
            12 => array('/api/content-type'),
            13 => array('/api/site'),
            14 => array('/api/site/list/available'),
//            15 => array('/api/theme'),
            16 => array('/api/role'),
            17 => array('/api/group'),
            18 => array('/api/redirection'),
            19 => array('/api/status'),
            20 => array('/api/status/list'),
            21 => array('/api/datatable/translation'),
            22 => array('/api/trashcan/list'),
            23 => array('/api/translation/tinymce'),
        );
    }
}
