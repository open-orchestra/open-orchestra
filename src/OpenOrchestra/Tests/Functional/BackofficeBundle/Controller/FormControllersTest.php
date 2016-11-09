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
            array('/admin/site/form/2'),
            array('/admin/status/new'),
            array('/admin/theme/new'),
            array('/admin/keyword/new'),
//            array('/admin/template/form/template_full'),
            array('/admin/content-type/new'),
            array('/admin/role/new'),
            array('/admin/group/new'),
            array('/admin/redirection/new'),
//             array('/admin/area/template/row/new/template_home/root'),
//             array('/admin/area/template/column/template_home/column-main'),
//             array('/admin/area/template/row/template_home/row_header'),
//             array('/admin/area/node/row/new/2/root/1/fr/root'),
//             array('/admin/area/node/column/2/root/1/fr/column-main'),
//             array('/admin/area/node/row/2/root/1/fr/row_header'),
        );
    }
}
