<?php

namespace OpenOrchestra\FunctionalTests\BackofficeBundle\Controller;

use OpenOrchestra\FunctionalTests\Utils\AbstractFormTest;
use OpenOrchestra\ModelInterface\Model\NodeInterface;
use OpenOrchestra\ModelInterface\Repository\NodeRepositoryInterface;
use OpenOrchestra\ModelInterface\Repository\SiteRepositoryInterface;

/**
 * Class SiteControllerTest
 *
 * @group backofficeTest
 */
class SiteControllerTest extends AbstractFormTest
{
    /**
     * @var NodeRepositoryInterface
     */
    protected $nodeRepository;

    /**
     * @var SiteRepositoryInterface
     */
    protected $siteRepository;

    protected $siteId;

    /**
     * Set up the test
     */
    public function setUp()
    {
        parent::setUp();

        $this->siteId = uniqid();
        $this->nodeRepository = static::$kernel->getContainer()->get('open_orchestra_model.repository.node');
        $this->siteRepository = static::$kernel->getContainer()->get('open_orchestra_model.repository.site');
    }

    /**
     * Test when you create a site and update it
     */
    public function testCreateSite()
    {
        $this->assertNodeCount(0, 'fr');
        $this->assertNodeCount(0, 'en');

        $this->createSite();

        $this->assertNodeCount(1, 'fr');
        $this->assertNodeCount(0, 'en');

        $crawler = $this->client->request('GET', '/admin/site/form/' . $this->siteId);
        $form = $crawler->selectButton('Save')->form();

        $values = $form->getPhpValues();

        $values['oo_site']['aliases'][1]['domain'] = $this->siteId . 'name';
        $values['oo_site']['aliases'][1]['language'] = 'en';
        $values['oo_site']['aliases'][1]['main'] = false;

        $this->client->request($form->getMethod(), $form->getUri(), $values, $form->getPhpFiles());

        $this->assertNodeCount(1, 'fr');
        $this->assertNodeCount(1, 'en');

        $this->client->request('DELETE', '/api/site/' . $this->siteId . '/delete');
    }

    /**
     * Test create 2 site with the same siteId only one is save
     */
    public function testUniqueSiteId()
    {
        $this->assertSiteCount(0, $this->siteId);

        $this->createSite();

        $this->assertSiteCount(1, $this->siteId);

        $this->createSite();

        $this->assertSiteCount(1, $this->siteId);

        $this->client->request('DELETE', '/api/site/' . $this->siteId . '/delete');
    }

    /**
     * Create a site
     */
    protected function createSite()
    {
        $crawler =  $this->client->request('GET', '/admin/site/new');

        $form = $crawler->selectButton('Save')->form();

        $form['oo_site[siteId]'] = $this->siteId;
        $form['oo_site[name]'] = $this->siteId . 'domain';
        $form['oo_site[metaAuthor]'] = $this->siteId . ' Author';

        $values = $form->getPhpValues();

        $values['oo_site']['aliases'][0]['domain'] = $this->siteId . 'name';
        $values['oo_site']['aliases'][0]['language'] = 'fr';
        $values['oo_site']['aliases'][0]['main'] = true;

        $this->client->request($form->getMethod(), $form->getUri(), $values, $form->getPhpFiles());
    }

    /**
     * @param int    $count
     * @param string $language
     */
    protected function assertNodeCount($count, $language)
    {
         $nodes = $this->nodeRepository->findNotDeletedSortByUpdatedAt(NodeInterface::ROOT_NODE_ID, $language, $this->siteId);

         $this->assertCount($count, $nodes);
    }

    /**
     * @param int    $count
     * @param string $siteId
     */
    protected function assertSiteCount($count, $siteId)
    {
        $sites = $this->siteRepository->findBy(array('siteId' => $siteId));

        $this->assertCount($count, $sites);
    }
}
