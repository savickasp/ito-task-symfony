<?php


namespace App\Command;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MarkInactiveUserComand extends Command
{
    protected static $defaultName = 'user:mark-inactive';

    protected function configure()
    {
        $this
            ->setDescription('marks inactive users in DB')
            ->setHelp('Command check all users last login time and if it is less then x (default 30) days it marks them in database as inactive users')
            ->addArgument('daysNumber', InputArgument::OPTIONAL, 'After how much days yser is inactive, default 30 days')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('First comamnd');

        return 0;
    }
}