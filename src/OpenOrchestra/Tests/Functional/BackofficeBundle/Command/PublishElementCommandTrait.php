<?php

namespace OpenOrchestra\FunctionalTests\BackofficeBundle\Command;

use Symfony\Component\Console\Tester\CommandTester;

/**
 * Class PublishElementCommandTrait
 */
trait PublishElementCommandTrait
{
    /**
     * @param string $siteId
     * @param string $commandName
     * @param string $repositoryName
     * @param string $entityName
     */
    public function executePublish($siteId, $commandName, $repositoryName, $entityName)
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
            '/Publishing '.$entityName.'s for siteId ' . $siteId . '/',
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
    /**
     * @param string $siteId
     * @param string $commandName
     * @param string $repositoryName
     * @param string $entityName
     */
    public function executeUnpublish($siteId, $commandName, $repositoryName, $entityName)
    {
        $command = $this->application->find($commandName);
        $commandTester = new CommandTester($command);

        $site = static::$kernel->getContainer()->get('open_orchestra_model.repository.site')->findOneBySiteId($siteId);
        $fromStatus = static::$kernel->getContainer()->get('open_orchestra_model.repository.status')
            ->findOneByPublished();
        $elements = static::$kernel->getContainer()->get($repositoryName)
            ->findElementToAutoUnpublish($site->getSiteId(), $fromStatus);

        $commandTester->execute(array('command' => $command->getName()));
        $this->assertRegExp(
            '/Unpublishing '.$entityName.'s for siteId ' . $siteId . '/',
            $commandTester->getDisplay()
        );

        foreach ($elements as $element) {
            $this->assertRegExp(
                '/-> ' . $element->getName() . ' \(v' . $element->getVersion() . ' ' . $element->getLanguage() . '\) unpublished/',
                $commandTester->getDisplay()
            );
        }

        $this->assertRegExp('/Done./', $commandTester->getDisplay());
    }
}
