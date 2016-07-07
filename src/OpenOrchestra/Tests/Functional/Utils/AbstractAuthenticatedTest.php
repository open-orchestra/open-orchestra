<?php

namespace OpenOrchestra\FunctionalTests\Utils;

use OpenOrchestra\BaseBundle\Tests\AbstractTest\AbstractWebTestCase;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

/**
 * Class AbstractAuthenticatedTest
 */
abstract class AbstractAuthenticatedTest extends AbstractWebTestCase
{
    /**
     * @var Client
     */
    protected $client;
    protected $accessToken = array();
    protected $username = 'admin';
    protected $password = 'admin';

    /**
     * Set up the test
     */
    public function setUp()
    {
        $this->client = static::createClient();
        $this->logIn();
    }

    /**
     * Log user with username
     */
    protected function logIn()
    {
        $container = $this->client->getContainer();
        $userManager = $container->get('fos_user.user_manager');

        $user = $userManager->findUserByUsername($this->username);

        $session = $this->client->getContainer()->get('session');
        $firewall = 'openorchestra';
        $token = new UsernamePasswordToken($user, null, $firewall, $user->getRoles());
        $session->set('_security_'.$firewall, serialize($token));
        $session->save();
        $container->get('fos_user.security.login_manager')->logInUser($firewall, $user);

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
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
