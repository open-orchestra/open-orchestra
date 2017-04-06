<?php

namespace OpenOrchestra\FunctionalTests\BackofficeBundle\Command;

use OpenOrchestra\BackofficeBundle\Command\OrchestraUnpublishNodeCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use OpenOrchestra\BaseBundle\Tests\AbstractTest\AbstractWebTestCase;
use OpenOrchestra\FunctionalTests\BackofficeBundle\Command\PublishElementCommandTrait;

/**
 * Class OrchestraUnpublishNodeCommandTest
 */
class OrchestraUnpublishNodeCommandTest extends AbstractWebTestCase
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
        $this->application->add(new OrchestraUnpublishNodeCommand());
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
        $this->executeUnpublish($siteId, 'orchestra:unpublish:node', 'open_orchestra_model.repository.node', 'node');
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
