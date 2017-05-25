<?php
/**
 * Created by PhpStorm.
 * User: naffiq
 * Date: 5/25/17
 * Time: 18:33
 */

namespace naffiq\RocketTools\nginx;


use naffiq\RocketTools\config\ConfigHelper;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class LinkCommand extends Command
{
    protected function configure()
    {
        $this->setName('nginx:link')
            ->setDescription('Links site from sites_available folder to sites_enabled folder')
            ->addArgument('site-name', InputArgument::REQUIRED, 'Configuration file name')
            ->addArgument(
                'sites-available', InputArgument::OPTIONAL, 'Sites available directory (without .conf)',
                ConfigHelper::get('nginx-sites-available', '/etc/nginx/sites-available')
            )->addArgument(
                'sites-enabled', InputArgument::OPTIONAL, 'Sites enabled directory',
                ConfigHelper::get('nginx-sites-enabled', '/etc/nginx/sites-enabled')
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $siteName = $input->getArgument('site-name');
        $sitesAvailablePath = $input->getArgument('sites-available');
        $sitesEnabledPath = $input->getArgument('sites-enabled');

        $fileName = $sitesAvailablePath . '/' . $siteName . '.conf';
        $outFileName = $sitesEnabledPath . '/' . $siteName . '.conf';

        if (!file_exists($fileName)) {
            $output->writeln("File {$fileName} doesn't exist" );
            die(1);
        }

        link($fileName, $outFileName);

        $output->writeln("File {$fileName} linked to {$outFileName}");
    }
}