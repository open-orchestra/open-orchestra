<?php

namespace OpenOrchestraBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpKernel\HttpKernel;

/**
 * Class OrchestraFunctionalTestCommand
 */
class OrchestraFunctionalTestCommand extends ContainerAwareCommand
{
    /**
     * Configure command
     */
    protected function configure()
    {
        $this
            ->setName('orchestra:functional')
            ->setDescription('Run functional tests');
    }

    /**
     * Execute command
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int 0 if everything went fine, or an error code
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->executeCommand('./app/console cache:clear --env=test', $output);
        $this->executeCommand('./app/console orchestra:mongodb:fixtures:load --env=test --type=functional', $output);
        $this->executeCommand('./app/console orchestra:elastica:index:drop', $output);
        $this->executeCommand('./app/console orchestra:elastica:index:create', $output);
        $this->executeCommand('./app/console orchestra:elastica:schema:create', $output);
        $this->executeCommand('./app/console orchestra:elastica:populate', $output);
        $this->executeCommand('./bin/phpunit --testsuite=functional', $output);
    }

    protected function executeCommand($command, OutputInterface $output)
    {
        $output->writeln(sprintf('<comment>%s</comment>', $command));
        while (@ ob_end_flush());
        $proc = popen("cd /var/www/openorchestra && $command 2>&1", 'r');
        while (!feof($proc))
        {
            $output->write(sprintf('<info>%s</info>', fread($proc, 4096)));
            @ flush();
        }
        pclose($proc);
    }

}
