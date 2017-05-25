<?php
/**
 * Created by PhpStorm.
 * User: naffiq
 * Date: 5/25/17
 * Time: 18:48
 */

namespace naffiq\RocketTools\nginx;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;

use naffiq\RocketTools\config\ConfigHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UnlinkCommand extends Command
{
    protected function configure()
    {
        $this->setName('nginx:unlink')
            ->setDescription('Unlink site from sites_enabled folder')
            ->addArgument('site-name', InputArgument::REQUIRED, 'Configuration file name')
            ->addArgument(
                'sites-enabled', InputArgument::OPTIONAL, 'Sites enabled directory',
                ConfigHelper::get('nginx-sites-enabled', '/etc/nginx/sites-enabled')
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $siteName = $input->getArgument('site-name');
        $sitesEnabledPath = $input->getArgument('sites-enabled');

        $fileName = $sitesEnabledPath . '/' . $siteName . '.conf';

        if (!file_exists($fileName)) {
            $output->writeln("File {$fileName} doesn't exist" );
            die(1);
        }

        unlink($fileName);

        $output->writeln("File {$fileName} unlinked");
    }
}