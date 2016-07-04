<?php

namespace OpenOrchestra\FunctionalTests\MediaAdminBundle\Controller;

use OpenOrchestra\FunctionalTests\ApiBundle\Controller\ApiControllersSecurityTest as BaseApiControllersSecurityTest;

/**
 * Class ApiControllersSecurityTest
 *
 * @group media
 */
class ApiControllersSecurityTest extends BaseApiControllersSecurityTest
{
    /**
     * @return array
     */
    public function provideApiUrl()
    {
        return array(
            array('/api/folder/folderId/delete', 'DELETE'),
            array('/api/media/mediaId/delete', 'DELETE'),
            array('/api/media/upload/folderId', 'POST'),
        );
    }
}
