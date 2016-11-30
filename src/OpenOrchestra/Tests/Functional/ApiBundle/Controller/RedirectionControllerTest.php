<?php

namespace OpenOrchestra\FunctionalTests\ApiBundle\Controller;

use OpenOrchestra\FunctionalTests\Utils\AbstractAuthenticatedTest;

/**
 * Class RedirectionControllerTest
 */
class RedirectionControllerTest extends AbstractAuthenticatedTest
{
    /**
     * Test cannot delete used status
     */
    public function testListAction()
    {
        $siteId = '2';
        $locale = 'fr';
        $nodeId = 'root';

        $this->client->request('GET', "api/redirection/node/$siteId/$nodeId/$locale");

        $this->assertSame(200, $this->client->getResponse()->getStatusCode());

        $json = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertCount(1, $json['redirections']);
    }
}
