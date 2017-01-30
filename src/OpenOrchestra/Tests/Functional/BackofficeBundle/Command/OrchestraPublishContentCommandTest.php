<?php

namespace OpenOrchestra\FuntionalTests\BackOfficeBundle\Command;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use OpenOrchestra\BackofficeBundle\Command\OrchestraPublishContentCommand;








/**
 * Class OrchestraPublishContentCommandTest
 */
class OrchestraPublishContentCommandTest extends OrchestraPublishElementCommandTest
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
        $this->executePublish($siteId, 'orchestra:publish:content', 'open_orchestra_model.repository.content');
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
