<?php

namespace OpenOrchestra\FunctionalTests\MediaAdminBundle\Controller;

use OpenOrchestra\FunctionalTests\BackofficeBundle\Controller\FormControllersSecurityTest as BaseFormControllersSecurityTest;

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
