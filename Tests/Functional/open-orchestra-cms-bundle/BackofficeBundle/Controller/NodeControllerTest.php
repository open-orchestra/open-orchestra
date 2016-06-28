<?php

namespace OpenOrchestra\BackofficeBundle\Tests\Functional\Controller;

use OpenOrchestra\ModelInterface\Model\NodeInterface;
use OpenOrchestra\ModelInterface\Repository\NodeRepositoryInterface;
use OpenOrchestra\ModelInterface\Model\StatusInterface;

/**
 * Class NodeControllerTest
 *
 * @group backofficeTest
 */
class NodeControllerTest extends AbstractControllerTest
{
    /**
     * @var NodeRepositoryInterface
     */
    protected $nodeRepository;
    protected $redirectionRepository;
    protected $routeDocumentRepository;
    protected $documentManager;
    protected $language = 'en';
    protected $siteId = '2';

    /**
     * Set up the test
     */
    public function setUp()
    {
        parent::setUp();

        $this->nodeRepository = static::$kernel->getContainer()->get('open_orchestra_model.repository.node');
        $this->redirectionRepository = static::$kernel->getContainer()->get('open_orchestra_model.repository.redirection');
        $this->routeDocumentRepository = static::$kernel->getContainer()->get('open_orchestra_model.repository.route_document');
        $this->documentManager = static::$kernel->getContainer()->get('object_manager');
    }

    /**
     * Test some of the node forms
     */
    public function testNodeForms()
    {
        $nodeRoot = $this->nodeRepository->findInLastVersion(NodeInterface::ROOT_NODE_ID, $this->language, $this->siteId);
        $nodeTransverse = $this->nodeRepository->findInLastVersion(NodeInterface::TRANSVERSE_NODE_ID, $this->language, $this->siteId);
        $nodeFixtureCommunity = $this->nodeRepository->findInLastVersion('fixture_page_community', $this->language, $this->siteId);

        $url = '/admin/node/form/' . $nodeRoot->getId();
        $this->client->request('GET', $url);
        $this->assertForm($this->client->getResponse());

        $url = '/admin/node/new/' . $nodeRoot->getNodeId();
        $this->client->request('GET', $url);
        $this->assertForm($this->client->getResponse());

        $url = '/admin/node/form/' . $nodeTransverse->getId();
        $this->client->request('GET', $url);
        $this->assertForm($this->client->getResponse());

        $url = '/admin/node/form/' . $nodeFixtureCommunity->getId();
        $this->client->request('GET', $url);
        $this->assertForm($this->client->getResponse());

        $url = '/admin/node/new/' . $nodeFixtureCommunity->getNodeId();
        $this->client->request('GET', $url);
        $this->assertForm($this->client->getResponse());

        $url = '/admin/area/form/' . $nodeFixtureCommunity->getId() . '/mainContentArea1';
        $this->client->request('GET', $url);
        $this->assertForm($this->client->getResponse());

        $url = '/admin/block/form/' . $nodeFixtureCommunity->getId();
        $this->client->request('GET', $url);
        $this->assertForm($this->client->getResponse());
    }

    /**
     * Test assert Node transverse always editable
     */
    public function testNodeTransverseEditable()
    {
        $this->markTestSkipped("Form submission broken by refacto on js error");

        $nodeTransverse = $this->nodeRepository->findInLastVersion(NodeInterface::TRANSVERSE_NODE_ID, $this->language, $this->siteId);

        $url = '/admin/node/form/' . $nodeTransverse->getId();
        $crawler = $this->client->request('GET', $url);
        $form = $crawler->selectButton('Save')->form();
        $this->client->submit($form);

        $this->assertForm($this->client->getResponse());
    }

    /**
     * test new Node
     */
    public function testNewNodePageHome()
    {
        $this->markTestSkipped("Form submission broken by refacto on js error");

        $crawler = $this->client->request('GET', '/admin/');
        $nbLink = $crawler->filter('a')->count();

        $crawler = $this->client->request('GET', '/admin/node/new/fixture_page_community');

        $formNode = $crawler->selectButton('Save')->form();

        $nodeName = 'fixturetest' . time();
        $formNode['oo_node[name]'] = $nodeName;
        $formNode['oo_node[boLabel]'] = $nodeName;
        $formNode['oo_node[nodeTemplateSelection][nodeSource]'] = 'root';
        $formNode['oo_node[routePattern]'] = '/page-test' .time();

        $this->client->submit($formNode);
        $crawler = $this->client->request('GET', '/admin/');

        $this->assertEquals($nbLink + 2, $crawler->filter('a')->count());

        $this->client->request('GET', '/api/node/' . $nodeName);
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame('application/json', $this->client->getResponse()->headers->get('content-type'));
        $node = json_decode($this->client->getResponse()->getContent());
        $nodeId = $node->id;

        $statusRepository = static::$kernel->getContainer()->get('open_orchestra_model.repository.status');
        $statuses = $statusRepository->findAll();

        $this->assertEquals(1, count($this->redirectionRepository->findAll()));
        $routeDocumentCount = count($this->routeDocumentRepository->findAll());

        $this->changeNodeStatusWithRouteRedirectionTest($nodeId, $statuses[2], 1, $routeDocumentCount);
        $this->changeNodeStatusWithRouteRedirectionTest($nodeId, $statuses[1], 1, $routeDocumentCount + 2);

        $this->client->request('POST', '/api/node/' . $nodeName . '/duplicate/1?language=' . $node->language, array());
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame('application/json', $this->client->getResponse()->headers->get('content-type'));

        $newNode = $this->nodeRepository->findInLastVersion($nodeName, $node->language, $this->siteId);
        $newNode->setRoutePattern('/page-test' .time());
        $this->documentManager->persist($newNode);
        $this->documentManager->flush($newNode);

        $this->changeNodeStatusWithRouteRedirectionTest($newNode->getId(), $statuses[2], 1, $routeDocumentCount + 2);
        $this->changeNodeStatusWithRouteRedirectionTest($newNode->getId(), $statuses[1], 3, $routeDocumentCount + 6);
        $this->changeNodeStatusWithRouteRedirectionTest($newNode->getId(), $statuses[0], 1, $routeDocumentCount + 2);
        $this->changeNodeStatusWithRouteRedirectionTest($nodeId, $statuses[0], 1, $routeDocumentCount);

        $this->client->request('DELETE', '/api/node/' . $nodeName . '/delete');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $this->assertEquals(1, count($this->redirectionRepository->findAll()));
        $this->assertEquals($routeDocumentCount, count($this->routeDocumentRepository->findAll()));
    }

    /**
     * change Node status
     *
     * @param string          $nodeId
     * @param StatusInterface $status
     * @param int             $redirectionNumber
     * @param int             $routeNumber
     */
    protected function changeNodeStatusWithRouteRedirectionTest($nodeId, StatusInterface $status, $redirectionNumber, $routeNumber)
    {
        $this->client->request('POST', '/api/node/' . $nodeId . '/update',
            array(), array(), array(), '{"status_id": "'. $status->getId() .'"}');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame('application/json', $this->client->getResponse()->headers->get('content-type'));
        $this->assertEquals($redirectionNumber, count($this->redirectionRepository->findAll()));
        $this->assertEquals($routeNumber, count($this->routeDocumentRepository->findAll()));
    }
}
