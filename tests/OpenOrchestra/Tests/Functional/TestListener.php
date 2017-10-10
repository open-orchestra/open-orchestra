<?php
namespace OpenOrchestra\FunctionalTests;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\ConsoleOutput;

class TestListener extends \PHPUnit_Framework_BaseTestListener
{
    public function startTestSuite(\PHPUnit_Framework_TestSuite $suite)
    {
        if (strpos($suite->getName(),"functional") !== false ) {

            $noParametersInput = new ArrayInput(array());
            $consoleOutput = new ConsoleOutput();

            $kernel = new \AppKernel('test', true); // create a "test" kernel
            $kernel->boot();

            $application = new Application($kernel);

            $consoleOutput->writeln(sprintf('<comment>%s</comment>', 'console cache:clear --env=test'));
            $command = $application->find('cache:clear');
            $command->run($noParametersInput, $consoleOutput);

            $consoleOutput->writeln(sprintf('<comment>%s</comment>', 'console orchestra:mongodb:fixtures:load --env=test --type=functional'));
            $command = $application->find('orchestra:mongodb:fixtures:load');
            $command->run(new ArrayInput(array(
                '--type' => 'functional'
            )), $consoleOutput);

            $consoleOutput->writeln(sprintf('<comment>%s</comment>', 'console orchestra:elastica:index:drop'));
            $command = $application->find('orchestra:elastica:index:drop');
            $command->run($noParametersInput, $consoleOutput);

            $consoleOutput->writeln(sprintf('<comment>%s</comment>', 'console orchestra:elastica:index:create'));
            $command = $application->find('orchestra:elastica:index:create');
            $command->run($noParametersInput, $consoleOutput);

            $consoleOutput->writeln(sprintf('<comment>%s</comment>', 'console orchestra:elastica:schema:create'));
            $command = $application->find('orchestra:elastica:schema:create');
            $command->run($noParametersInput, $consoleOutput);

            $consoleOutput->writeln(sprintf('<comment>%s</comment>', 'console orchestra:elastica:populate'));
            $command = $application->find('orchestra:elastica:populate');
            $command->run($noParametersInput, $consoleOutput);

            $consoleOutput->writeln(sprintf('<comment>%s</comment>', 'phpunit --testsuite=functional'));
        }
    }
}
