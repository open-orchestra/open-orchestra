<?php

namespace OpenOrchestra\FuntionalTests\BackOfficeBundle\Command;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use OpenOrchestra\BaseBundle\Tests\AbstractTest\AbstractWebTestCase;
use OpenOrchestra\BackofficeBundle\Command\OrchestraPublishNodeCommand;

/**
 * Class OrchestraPublishNodeCommandTest
 */
class OrchestraPublishNodeCommandTest extends AbstractWebTestCase
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
        $command = $this->application->find('orchestra:publish:node');
        $commandTester = new CommandTester($command);

        $site = static::$kernel->getContainer()->get('open_orchestra_model.repository.site')->findOneBySiteId($siteId);
        $fromStatus = static::$kernel->getContainer()->get('open_orchestra_model.repository.status')
            ->findByAutoPublishFrom();
        $nodes = static::$kernel->getContainer()->get('open_orchestra_model.repository.node')
            ->findElementToAutoPublish($site->getSiteId(), $fromStatus);

        $commandTester->execute(array('command' => $command->getName()));
        $this->assertRegExp(
            '/Publishing nodes for siteId ' . $siteId . '/',
            $commandTester->getDisplay()
        );

        foreach ($nodes as $node) {
            $this->assertRegExp(
                '/-> ' . $node->getName() . ' \(v' . $node->getVersion() . ' ' . $node->getLanguage() . '\) published/',
                $commandTester->getDisplay()
            );
        }

        $this->assertRegExp('/Done./', $commandTester->getDisplay());
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
