<?php

namespace MlankaTech\AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TrainOfflineCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('offline:train')
            ->setDescription('Set inactive trains offline');
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
        $output->writeln('<info>::::::::::::::::::Start Inactive Trains Offline</info>');
        $trainManager = $this->getContainer()->get('train.manager');
        $trainManager->setOffLine();
    }
}


