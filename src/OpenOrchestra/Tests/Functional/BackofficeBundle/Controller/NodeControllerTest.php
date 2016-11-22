<?php

namespace OpenOrchestra\FunctionalTests\BackofficeBundle\Controller;

use OpenOrchestra\FunctionalTests\Utils\AbstractFormTest;
use OpenOrchestra\ModelInterface\Model\NodeInterface;
use OpenOrchestra\ModelInterface\Repository\NodeRepositoryInterface;
use OpenOrchestra\ModelInterface\Model\StatusInterface;

/**
 * Class NodeControllerTest
 *
 * @group backofficeTest
 */
class NodeControllerTest extends AbstractFormTest
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
        $nodeFixtureCommunity = $this->nodeRepository->findInLastVersion('fixture_page_community', $this->language, $this->siteId);

         $url = '/admin/node/form/' . $nodeRoot->getId();
         $this->client->request('GET', $url);
         $this->assertForm($this->client->getResponse());

         $url = '/admin/node/new/' . $nodeRoot->getNodeId();
         $this->client->request('GET', $url);
         $this->assertForm($this->client->getResponse());

         $url = '/admin/node/form/' . $nodeFixtureCommunity->getId();
         $this->client->request('GET', $url);
         $this->assertForm($this->client->getResponse());

         $url = '/admin/node/new/' . $nodeFixtureCommunity->getNodeId();
         $this->client->request('GET', $url);
         $this->assertForm($this->client->getResponse());
    }

    /**
     * test new Node
     */
    public function testNewNodePageHome()
    {
        $this->markTestSkipped('To reactivate when API roles will be implemented');

        $crawler = $this->client->request('GET', '/admin/');

        $crawler = $this->client->request('GET', '/admin/node/new/fixture_page_community');

        $formNode = $crawler->selectButton('Save')->form();

        $nodeName = 'fixturetest' . time();
        $formNode['oo_node[name]'] = $nodeName;
        $formNode['oo_node[boLabel]'] = $nodeName;
        $formNode['oo_node[nodeTemplateSelection][nodeSource]'] = 'root';
        $formNode['oo_node[routePattern]'] = '/page-test' .time();

        $this->submitForm($formNode);

        $this->client->request('GET', '/api/node/' . $nodeName);
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame('application/json', $this->client->getResponse()->headers->get('content-type'));
        $node = json_decode($this->client->getResponse()->getContent());
        $nodeId = $node->id;

        $statusRepository = static::$kernel->getContainer()->get('open_orchestra_model.repository.status');
        $statuses = array();
        $statuses[0] = $statusRepository->findOneBy(array("name" => "draft"));
        $statuses[1] = $statusRepository->findOneBy(array("name" => "published"));
        $statuses[2] = $statusRepository->findOneBy(array("name" => "pending"));

        $this->assertEquals(1, count($this->redirectionRepository->findAll()));
        $routeDocumentCount = count($this->routeDocumentRepository->findAll());

        $this->changeNodeStatusWithRouteRedirectionTest($nodeId, $statuses[2], 1, $routeDocumentCount);
        $this->changeNodeStatusWithRouteRedirectionTest($nodeId, $statuses[1], 1, $routeDocumentCount + 2);

        $this->client->request('POST', '/api/node/' . $nodeName . '/new-version/1?language=' . $node->language, array());
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
