<?php

namespace OpenOrchestra\FuntionalTests\BackOfficeBundle\Command;

use OpenOrchestra\BackofficeBundle\Command\OrchestraUnpublishNodeCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use OpenOrchestra\BaseBundle\Tests\AbstractTest\AbstractWebTestCase;

/**
 * Class OrchestraUnpublishNodeCommandTest
 */
class OrchestraUnpublishNodeCommandTest extends AbstractWebTestCase
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
        $command = $this->application->find('orchestra:unpublish:node');
        $commandTester = new CommandTester($command);

        $site = static::$kernel->getContainer()->get('open_orchestra_model.repository.site')->findOneBySiteId($siteId);
        $publishedStatus = static::$kernel->getContainer()->get('open_orchestra_model.repository.status')
            ->findOneByPublished();
        $nodes = static::$kernel->getContainer()->get('open_orchestra_model.repository.node')
            ->findNodeToAutoUnpublish($site->getSiteId(), $publishedStatus);

        $commandTester->execute(array('command' => $command->getName()));
        $this->assertRegExp(
            '/Unpublishing nodes for siteId ' . $siteId . '/',
            $commandTester->getDisplay()
        );

        foreach ($nodes as $node) {
            $this->assertRegExp(
                '/-> ' . $node->getBOLabel(). ' \(v' . $node->getVersion() . ' ' . $node->getLanguage() . '\) unpublished/',
                $commandTester->getDisplay()
            );
        }

        $this->assertRegExp('/Done./', $commandTester->getDisplay());
    }

    /**
     * Provide sites aliases
     */
    public function provideSiteId()
    {
        return array(
            array('2'),
        );
    }
}
