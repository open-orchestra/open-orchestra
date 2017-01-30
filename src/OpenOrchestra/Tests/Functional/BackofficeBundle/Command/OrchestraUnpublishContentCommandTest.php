<?php

namespace OpenOrchestra\FuntionalTests\BackOfficeBundle\Command;

use OpenOrchestra\BackofficeBundle\Command\OrchestraUnpublishContentCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use OpenOrchestra\BaseBundle\Tests\AbstractTest\AbstractWebTestCase;

/**
 * Class OrchestraUnpublishContentCommandTest
 */
class OrchestraUnpublishContentCommandTest extends AbstractWebTestCase
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
        $this->application->add(new OrchestraUnpublishContentCommand());
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
        $this->execute($siteId, 'orchestra:unpublish:content', 'open_orchestra_model.repository.content', 'content', 'Unpublishing', 'unpublished');
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
