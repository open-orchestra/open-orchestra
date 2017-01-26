<?php

namespace OpenOrchestra\FunctionalTests\BackofficeBundle\Controller;

use OpenOrchestra\FunctionalTests\Utils\AbstractFormTest;

/**
 * Class FormControllersTest
 *
 * @group backofficeTest
 */
class FormControllersTest extends AbstractFormTest
{
    protected $username = 'developer';
    protected $password = 'developer';

    /**
     * @param string $url
     *
     * @dataProvider provideApiUrl
     */
    public function testForm($url)
    {
        $this->client->request('GET', $url);

        $this->assertForm($this->client->getResponse());
    }

    /**
     * @return array
     */
    public function provideApiUrl()
    {
        return array(
            1 => array('/admin/site/form/2'),
            2 => array('/admin/status/new'),
            3 => array('/admin/theme/new'),
            4 => array('/admin/keyword/new'),
            5 => array('/admin/content-type/new'),
            6 => array('/admin/group/new'),
            8 => array('/admin/redirection/new'),
            9 => array('/admin/node/form/2/root/fr'),
            10 => array('/admin/block/new/shared/menu/fr'),
            11 => array('/admin/keyword/new'),
        );
    }
}
