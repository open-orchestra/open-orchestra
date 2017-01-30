<?php

namespace OpenOrchestra\FuntionalTests\BackOfficeBundle\Command;

use OpenOrchestra\BackofficeBundle\Command\OrchestraUnpublishNodeCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use OpenOrchestra\BaseBundle\Tests\AbstractTest\AbstractWebTestCase;

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
        $this->execute($siteId, 'orchestra:unpublish:node', 'open_orchestra_model.repository.node', 'node', 'Unpublishing', 'unpublished');
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
