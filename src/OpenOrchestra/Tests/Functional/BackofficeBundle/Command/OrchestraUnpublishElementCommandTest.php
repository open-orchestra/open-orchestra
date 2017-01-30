<?php

namespace OpenOrchestra\FuntionalTests\BackOfficeBundle\Command;

use Symfony\Component\Console\Tester\CommandTester;
use OpenOrchestra\BaseBundle\Tests\AbstractTest\AbstractWebTestCase;

/**
 * Class OrchestraUnpublishElementCommandTest
 */
abstract class OrchestraUnpublishElementCommandTest extends AbstractWebTestCase
{
    /**
     * @param string $siteId
     * @param string $commandName
     * @param string $repositoryName
     */
    public function executeUnpublish($siteId, $commandName, $repositoryName)
    {
        $command = $this->application->find($commandName);
        $commandTester = new CommandTester($command);

        $site = static::$kernel->getContainer()->get('open_orchestra_model.repository.site')->findOneBySiteId($siteId);
        $publishedStatus = static::$kernel->getContainer()->get('open_orchestra_model.repository.status')
            ->findOneByPublished();
        $elements = static::$kernel->getContainer()->get($repositoryName)
            ->findElementToAutoUnpublish($site->getSiteId(), $publishedStatus);

        $commandTester->execute(array('command' => $command->getName()));
        $this->assertRegExp(
            '/Unpublishing nodes for siteId ' . $siteId . '/',
            $commandTester->getDisplay()
        );

        foreach ($elements as $element) {
            $this->assertRegExp(
                '/-> ' . $element->getName(). ' \(v' . $element->getVersion() . ' ' . $element->getLanguage() . '\) unpublished/',
                $commandTester->getDisplay()
            );
        }

        $this->assertRegExp('/Done./', $commandTester->getDisplay());
    }
}
