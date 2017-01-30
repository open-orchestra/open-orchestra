<?php

namespace OpenOrchestra\FuntionalTests\BackOfficeBundle\Command;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use OpenOrchestra\BackofficeBundle\Command\OrchestraPublishContentCommand;
use OpenOrchestra\BaseBundle\Tests\AbstractTest\AbstractWebTestCase;
use OpenOrchestra\FuntionalTests\BackOfficeBundle\Command\PublishElementCommandTrait;

/**
 * Class OrchestraPublishContentCommandTest
 */
class OrchestraPublishContentCommandTest extends AbstractWebTestCase
{
    use PublishElementCommandTrait;

    protected $application;

    /**
     * Set Up
     */
    public function setUp()
    {
        $client = self::createClient();
        $this->application = new Application($client->getKernel());
        $this->application->setAutoExit(false);
        $this->application->add(new OrchestraPublishContentCommand());
    }

    /**
     * Test the command
     *
     * @param string $siteId
     *
     * @dataProvider provideSiteId
     */
    public function testExecute($siteId)
    {
        $this->execute($siteId, 'orchestra:publish:content', 'open_orchestra_model.repository.content', 'content', 'Publishing', 'published');
    }

    /**
     * Provide site id
     */
    public function provideSiteId()
    {
        return array(
            array('2'),
        );
    }
}
