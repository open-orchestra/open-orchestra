<?php

namespace OpenOrchestra\FunctionalTests\Utils;

use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\DomCrawler\Form;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AbstractFormTest
 */
abstract class AbstractFormTest extends AbstractAuthenticatedTest
{

    /**
     * @param Form $form
     *
     * @return Crawler
     */
    protected function submitForm(Form $form)
    {
        return $this->client->submit($form);
    }

    /**
     * @param Response $response
     */
    protected function assertForm(Response $response)
    {
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertRegExp('/form/', $response->getContent());
        $this->assertNotRegExp('/<html/', $response->getContent());
        $this->assertNotRegExp('/_username/', $response->getContent());
    }
}
