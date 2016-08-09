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
        $this->client->request('GET', '/admin/2/homepage/en');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $this->client->request('GET', '/api/node/root');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $json = json_decode($this->client->getResponse()->getContent(), true);

        $area = $json['root_area']['areas'][1];
        $this->assertSame('myMain', $area['area_id']);
        $subArea = $area['areas'][0];
        $this->assertSame('mainContentArea1', $subArea['area_id']);
        $block = $subArea['blocks'][0];
        $update = $subArea['links']['_self_update_block'];


        // Remove ref of area in block
        $formData = json_encode(array(
            'area_id' => 'mainContentArea1',
            'blocks' => array()
        ));

        $this->client->request('POST', $update, array(), array(), array(), $formData);
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $language = $this->currentSiteManager->getCurrentSiteDefaultLanguage();
        $siteId = $this->currentSiteManager->getCurrentSiteId();
        $nodeAfter = $this->nodeRepository->findInLastVersion($block['node_id'], $language, $siteId);
        $this->assertSame(
            array(array('nodeId' => 0, 'areaId' => 'header')),
            $nodeAfter->getBlock(0)->getAreas()
        );

        // Add ref of area in block
        $formData = json_encode(array(
            'area_id' => 'mainContentArea1',
            'blocks' => array(array('node_id' => 'root', 'block_id' => 0))
        ));

        $this->client->request('POST', $update, array(), array(), array(), $formData);
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
}
