<?php
/**
 * Created by PhpStorm.
 * User: naffiq
 * Date: 5/25/17
 * Time: 16:00
 */

namespace naffiq\RocketTools\nginx;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('generate:nginx-config')
            ->setDescription('Generates nginx config for development');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $input->setInteractive(true);

        $input->getOption('');

        $output->writeln('Hello world!');
    }
}