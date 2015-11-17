<?php

namespace MlankaTech\AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MotorCoachOfflineCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('offline:motorcoach')
            ->setDescription('Set inactive motor coaches offline');
    }

    /**
     * Execute command.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<info>::::::::::::::::::Start Inactive Motor Coaches Offline</info>');
        $motorCoachManager = $this->getContainer()->get('motor.coach.manager');
        $motorCoachManager->setOffLine();
    }
}


