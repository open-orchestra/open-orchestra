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
     * test duplicate group Api
     */
    public function testDuplicateGroupApi()
    {
        $this->groupRepository = static::$kernel->getContainer()->get('open_orchestra_user.repository.group');
        $group = $this->groupRepository->findOneByName('Demo group');
        $group = static::$kernel->getContainer()->get('open_orchestra_api.transformer_manager')->get('group')->transform($group);
        $group = static::$kernel->getContainer()->get('jms_serializer')->serialize(
            $group,
            'json'
        );
        $this->client->request("POST", '/api/group/duplicate', array(), array(), array(), $group);
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame('application/json', $this->client->getResponse()->headers->get('content-type'));

        $group = $this->groupRepository->findOneByName(new \MongoRegex('/^Demo group_.*$/'));
        static::$kernel->getContainer()->get('object_manager')->remove($group);
        static::$kernel->getContainer()->get('object_manager')->flush();
    }

    /**
     * @param string $url
     * @param string $getParameter
     *
     * @dataProvider provideApiUrl
     */
    public function testApi($url, $getParameter = '', $method = 'GET')
    {
        $baseGetParameter = '?access_token=' . $this->getAccessToken();
        $this->client->request($method, $url . $baseGetParameter . $getParameter);
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
            8  => array('/api/block/list/shared/fr'),
            //8  => array('/api/content'),
            9  => array('/api/content/list/by-author'),
            10 => array('/api/content/list/not-published-by-author'),
            //11 => array('/api/content', '&content_type=news'),
            12 => array('/api/content-type'),
            13 => array('/api/site'),
            14 => array('/api/site/list/available'),
            // 15 => array('/api/theme'),
            17 => array('/api/group/delete-multiple', '', 'DELETE'),
            //18 => array('/api/redirection'),
            //19 => array('/api/status'),
            //20 => array('/api/status/list'),
            // 22 => array('/api/trashcan/list'),
            23 => array('/api/translation/tinymce'),
            24  => array('/api/node/list/tree/2/fr'),
            25  => array('/api/node/list/tree/2/fr/root'),
            26  => array('/api/group/user/list'),
            27  => array('/api/group/list'),
            28  => array('/api/block/list/block-component'),
        );
    }
}
