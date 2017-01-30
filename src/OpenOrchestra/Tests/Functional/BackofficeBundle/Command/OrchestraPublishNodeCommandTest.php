<?php

namespace OpenOrchestra\FuntionalTests\BackOfficeBundle\Command;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use OpenOrchestra\BackofficeBundle\Command\OrchestraPublishNodeCommand;

/**
 * Class OrchestraPublishNodeCommandTest
 */
class OrchestraPublishNodeCommandTest extends OrchestraPublishElementCommandTest
{
    protected $application;

    /**
     * Set Up
     */
    public function setUp()
    {
        $client = self::createClient();
        $this->application = new Application($client->getKernel());
        $this->application->setAutoExit(false);
        $this->application->add(new OrchestraPublishNodeCommand());
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
        $this->executePublish($siteId, 'orchestra:publish:node', 'open_orchestra_model.repository.node');
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
