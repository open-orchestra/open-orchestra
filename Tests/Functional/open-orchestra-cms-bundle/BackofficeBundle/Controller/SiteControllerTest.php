<?php

namespace OpenOrchestra\BackofficeBundle\Tests\Functional\Controller;

use OpenOrchestra\ModelInterface\Model\NodeInterface;
use OpenOrchestra\ModelInterface\Repository\NodeRepositoryInterface;
use OpenOrchestra\ModelInterface\Repository\SiteRepositoryInterface;

/**
 * Class SiteControllerTest
 *
 * @group backofficeTest
 */
class SiteControllerTest extends AbstractControllerTest
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

        $this->siteId = (string) microtime(true);
        $this->nodeRepository = static::$kernel->getContainer()->get('open_orchestra_model.repository.node');
        $this->siteRepository = static::$kernel->getContainer()->get('open_orchestra_model.repository.site');
    }

    /**
     * Test when you create a site and update it
     */
    public function testCreateSite()
    {
        $this->markTestSkipped("Form submission broken by refacto on js error");

        $this->assertNodeCount(0, 'fr');
        $this->assertNodeCount(0, 'en');

        $this->createSite();

        $this->assertNodeCount(1, 'fr');
        $this->assertNodeCount(0, 'en');

        $crawler = $this->client->request('GET', '/admin/site/form/' . $this->siteId);
        $form = $crawler->selectButton('Save')->form();
        foreach($form->all() as $key => $value){
            if (preg_match('/^oo_site\[aliases\]\[.*\]\[language\]$/', $key)) {
                $form[$key] = 'en';
            }
        }
        $this->client->submit($form);

        $this->assertNodeCount(1, 'fr');
        $this->assertNodeCount(1, 'en');
    }

    /**
     * Test create 2 site with the same siteId only one is save
     */
    public function testUniqueSiteId()
    {
        $this->markTestSkipped("Form submission broken by refacto on js error");

        $this->assertSiteCount(0, $this->siteId);

        $this->createSite();

        $this->assertSiteCount(1, $this->siteId);

        $this->createSite();

        $this->assertSiteCount(1, $this->siteId);
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
        foreach($form->all() as $key => $value){
            if (preg_match('/^oo_site\[aliases\]\[.*\]\[domain\]$/', $key)) {
                $form[$key] = $this->siteId . 'name';
            }
            if (preg_match('/^oo_site\[aliases\]\[.*\]\[language\]$/', $key)) {
                $form[$key] = 'fr';
            }
            if (preg_match('/^oo_site\[aliases\]\[.*\]\[main\]$/', $key)) {
                $form[$key] = true;
            }
        }

        $this->client->submit($form);
    }

    /**
     * @param int    $count
     * @param string $language
     */
    protected function assertNodeCount($count, $language)
    {
        $nodes = $this->nodeRepository->findByNodeAndLanguageAndSite(NodeInterface::TRANSVERSE_NODE_ID, $language, $this->siteId);

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
