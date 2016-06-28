<?php

namespace OpenOrchestra\ApiBundle\Tests\Functional\Controller;

/**
 * Class AreaControllerTest
 *
 * @group apiFunctional
 */
class AreaControllerTest extends AbstractControllerTest
{
    /**
     * Set up the test
     */
    public function setUp()
    {
        $this->client = static::createClient();

        $crawler = $this->client->request('GET', '/login');

        $form = $crawler->selectButton('Log in')->form();
        $form['_username'] = $this->username;
        $form['_password'] = $this->password;

        $this->client->submit($form);

        $this->currentSiteManager = static::$kernel->getContainer()->get('open_orchestra_backoffice.context_manager');
        $this->nodeRepository = static::$kernel->getContainer()->get('open_orchestra_model.repository.node');
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
        $area = $json['areas'][1];
        $this->assertSame('myMain', $area['area_id']);
        $subArea = $area['areas'][0];
        $this->assertSame('mainContentArea1', $subArea['area_id']);
        $block = $subArea['blocks'][0];
        $update = $subArea['links']['_self_block'];


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

    /**
     * Test block addition on transverse node
     */
    public function testDuplicateBlockInTransverseNodes()
    {
        $this->client->request('GET', '/admin/2/homepage/en');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $this->client->request('GET', '/api/node/transverse?language=fr');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $transverseNodeFrJson = json_decode($this->client->getResponse()->getContent(), true);

        $area = $transverseNodeFrJson['areas'][0];
        $updateLink = $area['links']['_self_block'];
        $blockCount = count($area['blocks']);

        $blocksDataToSend = array();
        for ($i = 0; $i < $blockCount; $i++) {
            $blocksDataToSend[] = array('node_id' => 'transverse', 'block_id' => $i);
        }
        $blocksDataToSend[] = array('component' => 'audience_analysis');

        $datas = json_encode(array(
            'area_id' => 'main',
            'blocks' => $blocksDataToSend
        ));
        $this->client->request('POST', $updateLink, array(), array(), array(), $datas);
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        foreach (array('en', 'fr', 'de') as $language) {
            $this->client->request('GET', '/api/node/transverse?language=' . $language);
            $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
            $newTransverseNodeFrJson = json_decode($this->client->getResponse()->getContent(), true);

            $newArea = $newTransverseNodeFrJson['areas'][0];
            $this->assertCount($blockCount + 1, $newArea['blocks']);
        }
    }
}
