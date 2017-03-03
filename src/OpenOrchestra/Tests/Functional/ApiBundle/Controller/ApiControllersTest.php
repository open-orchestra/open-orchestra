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
     * test duplicate Api
     *
     *
     * @dataProvider provideDuplicateApiElements
     */
    public function testDuplicateApi($repositoryName, $method, $value, $type, $url)
    {
        $repository = static::$kernel->getContainer()->get($repositoryName);
        $source = $repository->$method($value);
        $source = static::$kernel->getContainer()->get('open_orchestra_api.transformer_manager')->get($type)->transform($source);
        $source = static::$kernel->getContainer()->get('jms_serializer')->serialize(
            $source,
            'json'
            );
        $this->client->request("POST", $url, array(), array(), array(), $source);
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame('application/json', $this->client->getResponse()->headers->get('content-type'));

        $element = $repository->$method(new \MongoRegex('/^'.$value.'_.*$/'));
        while (!is_null($element)) {
            static::$kernel->getContainer()->get('object_manager')->remove($element);
            static::$kernel->getContainer()->get('object_manager')->flush();
            $element = $repository->$method(new \MongoRegex('/^'.$value.'_.*$/'));
        }
    }

    /**
     * @return array
     */
    public function provideDuplicateApiElements()
    {
        return array(
            0  => array('open_orchestra_user.repository.group', 'findOneByName', 'Demo group', 'group', '/api/group/duplicate'),
            1  => array('open_orchestra_model.repository.content', 'findOneByContentId', '206_3_portes', 'content', '/api/content/duplicate'),
        );
    }

    /**
     * @param string $url
     * @param string $getParameter
     * @param string $method
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
            1  => array('/api/node/show/root/2/fr'),
            5  => array('/api/node/list/not-published-by-author'),
            6  => array('/api/node/list/by-author'),
            7  => array('/api/node/list/2/fr'),
            8  => array('/api/block/list/shared/fr'),
            9  => array('/api/content/list/by-author'),
            10 => array('/api/content/list/not-published-by-author'),
            12 => array('/api/content-type'),
            13 => array('/api/site'),
            14 => array('/api/site/list/available'),
            17 => array('/api/group/delete-multiple', '', 'DELETE'),
            18 => array('/api/redirection/delete-multiple', '', 'DELETE'),
            19 => array('/api/status'),
            20 => array('/api/status/list'),
            24 => array('/api/node/list/tree/2/fr'),
            25 => array('/api/node/list/tree/2/fr/root'),
            26 => array('/api/group/user/list'),
            27 => array('/api/group/list'),
            28 => array('/api/block/list/block-component'),
            29 => array('/api/content-type/content/content-type-list'),
            30 => array('/api/content/delete-multiple', '', 'DELETE'),
            31 => array('/api/keyword/delete-multiple', '', "DELETE"),
            32 => array('/api/keyword'),
            33 => array('/api/node/list/with-block-in-area/root/2/header'),
            34 => array('/api/content/list-version/r5_3_portes/fr'),
            35 => array('/api/content/delete-multiple-version/r5_3_portes/fr', '', 'DELETE'),
            36 => array('/api/content/new-version/r5_3_portes/fr/2', '', 'POST'),
            37 => array('/api/node/new-version/root/fr/1', '', 'POST'),
            38 => array('/api/node/list-version/root/fr'),
            39 => array('/api/node/delete-multiple-version/root/fr', '', 'DELETE'),
            40 => array('/api/content-type'),
            41 => array('/api/content-type/news'),
            42 => array('/api/content-type/content/content-type-list'),
            43 => array('/api/trashcan/list'),
            44 => array('/api/trashcan/delete-multiple', '', "DELETE")
        );
    }
}

