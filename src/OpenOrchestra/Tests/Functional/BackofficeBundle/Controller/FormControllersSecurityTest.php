<?php

namespace OpenOrchestra\FunctionalTests\BackofficeBundle\Controller;

use OpenOrchestra\FunctionalTests\Utils\AbstractAuthenticatedTest;

/**
 * Class FormControllersSecurityTest
 *
 * @group backofficeTest
 */
class FormControllersSecurityTest extends AbstractAuthenticatedTest
{
    protected $username = 'userNoAccess';
    protected $password = 'userNoAccess';

    /**
     * @param string $url
     *
     * @dataProvider provideApiUrl
     */
    public function testForm($url)
    {
        $this->client->request('GET', $url);
        $this->assertEquals(403, $this->client->getResponse()->getStatusCode());
    }

    /**
     * @return array
     */
    public function provideApiUrl()
    {
        return array(
            1  => array('/admin/node/new/root'),
            2  => array('/admin/form/root'),
            3  => array('/admin/new'),
            4  => array('/admin/content-type/form/content-type-id'),
            5  => array('/admin/content-type/form/new'),
            6  => array('/admin/site/form/root'),
            7  => array('/admin/site/new'),
            8  => array('/admin/keyword/form/keyword-id}'),
            9  => array('/admin/keyword/new'),
            10 => array('/admin/group/new'),
            11 => array('/admin/group/form/group-id'),
            12 => array('/admin/content/form/root'),
            13 => array('/admin/content/new/root'),
            14 => array('/admin/redirection/form/redirection-id'),
            15 => array('/admin/redirection/new'),
//             16 => array('/admin/theme/form/theme-id'),
//             17 => array('/admin/theme/new'),
            18 => array('/admin/status/form/root'),
            19 => array('/admin/status/new'),
            20 => array('/admin/role/new'),
            21 => array('/admin/role/form/root'),
            22  => array('/node/form/2/root/fr'),
        );
    }
}
