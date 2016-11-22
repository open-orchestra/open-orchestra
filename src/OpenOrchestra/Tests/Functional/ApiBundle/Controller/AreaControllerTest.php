<?php

namespace OpenOrchestra\FunctionalTests\ApiBundle\Controller;

use Phake;
use OpenOrchestra\FunctionalTests\Utils\AbstractAuthenticatedTest;
use OpenOrchestra\ModelInterface\Repository\NodeRepositoryInterface;

/**
 * Class AreaControllerTest
 *
 * @group apiFunctional
 */
class AreaControllerTest extends AbstractAuthenticatedTest
{
    /**
     * @var NodeRepositoryInterface
     */
    protected $nodeRepository;
    protected $currentSiteManager;

    /**
     * Set up the test
     */
    public function setUp()
    {
        parent::setUp();
        $this->nodeRepository = static::$kernel->getContainer()->get('open_orchestra_model.repository.node');
        $this->currentSiteManager = Phake::mock('OpenOrchestra\Backoffice\Context\ContextManager');
        Phake::when($this->currentSiteManager)->getCurrentSiteId()->thenReturn('2');
        Phake::when($this->currentSiteManager)->getCurrentSiteDefaultLanguage()->thenReturn('fr');
        static::$kernel->getContainer()->set('open_orchestra_backoffice.context_manager', $this->currentSiteManager);
    }

    /**
     * test reverse transform
     */
    public function testAreaReverseTransform()
    {
        $this->markTestSkipped('To reactivate when API roles will be implemented');

        $this->client->request('GET', '/admin/2/homepage/en');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $this->client->request('GET', '/api/node/root/show-or-create');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $json = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertEquals(true, array_key_exists('main', $json['areas']));
        $this->assertEquals(true, array_key_exists('header', $json['areas']));
        $this->assertEquals(true, array_key_exists('footer', $json['areas']));
    }
}
