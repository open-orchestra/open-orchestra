<?php

namespace OpenOrchestra\FuntionalTests\BackOfficeBundle\Command;

use Symfony\Component\Console\Tester\CommandTester;
use OpenOrchestra\BaseBundle\Tests\AbstractTest\AbstractWebTestCase;

/**
 * Class OrchestraPublishElementCommandTest
 */
abstract class OrchestraPublishElementCommandTest extends AbstractWebTestCase
{
    /**
     * @param string $siteId
     * @param string $commandName
     * @param string $repositoryName
     */
    public function executePublish($siteId, $commandName, $repositoryName)
    {
        $command = $this->application->find($commandName);
        $commandTester = new CommandTester($command);

        $site = static::$kernel->getContainer()->get('open_orchestra_model.repository.site')->findOneBySiteId($siteId);
        $fromStatus = static::$kernel->getContainer()->get('open_orchestra_model.repository.status')
            ->findByAutoPublishFrom();
        $elements = static::$kernel->getContainer()->get($repositoryName)
            ->findElementToAutoPublish($site->getSiteId(), $fromStatus);

        $commandTester->execute(array('command' => $command->getName()));
        $this->assertRegExp(
            '/Publishing nodes for siteId ' . $siteId . '/',
            $commandTester->getDisplay()
        );

        foreach ($elements as $element) {
            $this->assertRegExp(
                '/-> ' . $element->getName() . ' \(v' . $element->getVersion() . ' ' . $element->getLanguage() . '\) published/',
                $commandTester->getDisplay()
            );
        }

        $this->assertRegExp('/Done./', $commandTester->getDisplay());
    }
}
