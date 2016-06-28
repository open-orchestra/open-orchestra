<?php

namespace OpenOrchestra\ApiBundle\Tests\Functional\Controller;

use OpenOrchestra\BaseBundle\Tests\AbstractTest\AbstractWebTestCase;
use Phake;
use OpenOrchestra\ModelInterface\Repository\NodeRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Client;

/**
 * Class AbstractControllerTest
 */
abstract class AbstractControllerTest extends AbstractWebTestCase
{
    /**
     * @var Client
     */
    protected $client;

    protected $currentSiteManager;
    protected $username = 'admin';
    protected $password = 'admin';
    protected $accessToken = array();

    /**
     * @var NodeRepositoryInterface
     */
    protected $nodeRepository;

    /**
     * Set up the test
     */
    public function setUp()
    {
        $this->client = static::createClient();

        $this->currentSiteManager = Phake::mock('OpenOrchestra\Backoffice\Context\ContextManager');
        Phake::when($this->currentSiteManager)->getCurrentSiteId()->thenReturn('2');
        Phake::when($this->currentSiteManager)->getCurrentSiteDefaultLanguage()->thenReturn('fr');
        static::$kernel->getContainer()->set('open_orchestra_backoffice.context_manager', $this->currentSiteManager);

        $this->nodeRepository = static::$kernel->getContainer()->get('open_orchestra_model.repository.node');
    }

    /**
     * @return string
     */
    protected function getUsername()
    {
        return $this->username;
    }

    /**
     * @return string
     */
    protected function getPassword()
    {
        return $this->password;
    }

    /**
     * @return mixed
     */
    protected function getAccessToken()
    {
        if (!array_key_exists($this->getUsername(), $this->accessToken)) {
            $this->client->request('GET', '/oauth/access_token?grant_type=password&username=' . $this->getUsername() . '&password=' . $this->getPassword(), array(), array(), array('PHP_AUTH_USER' => 'test_key', 'PHP_AUTH_PW' => 'test_secret'));
            $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
            $this->assertSame('application/json', $this->client->getResponse()->headers->get('content-type'));
            $tokenReponse = json_decode($this->client->getResponse()->getContent(), true);
            $this->accessToken[$this->getUsername()] = $tokenReponse['access_token'];
        }

        return $this->accessToken[$this->getUsername()];
    }
}
