<?php

namespace OpenOrchestra\FuntionalTests\BackOfficeBundle\Command;

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
     */
    public function execute($siteId, $commandName, $repositoryName, $entityName, $text, $state)
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
            '/'.$text.' '.$entityName.'s for siteId ' . $siteId . '/',
            $commandTester->getDisplay()
        );

        foreach ($elements as $element) {
            $this->assertRegExp(
                '/-> ' . $element->getName() . ' \(v' . $element->getVersion() . ' ' . $element->getLanguage() . '\) '.$state.'/',
                $commandTester->getDisplay()
            );
        }

        $this->assertRegExp('/Done./', $commandTester->getDisplay());
    }
}
