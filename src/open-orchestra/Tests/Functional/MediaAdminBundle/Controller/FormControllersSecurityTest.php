<?php

namespace OpenOrchestra\MediaAdminBundle\Tests\Functional\Controller;

use OpenOrchestra\BackofficeBundle\Tests\Functional\Controller\FormControllersSecurityTest as BaseFormControllersSecurityTest;

/**
 * Class FormControllersSecurityTest
 *
 * @group media
 */
class FormControllersSecurityTest extends BaseFormControllersSecurityTest
{
    /**
     * @return array
     */
    public function provideApiUrl()
    {
        return array(
            array('/admin/folder/form/folderId'),
            array('/admin/folder/new/parentId'),
            array('/admin/folder/list'),
            array('/admin/media/mediaId/crop'),
            array('/admin/media/override/mediaId/format'),
            array('/admin/media/mediaId/meta'),
        );
    }
}
