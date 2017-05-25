<?php
/**
 * Created by PhpStorm.
 * User: naffiq
 * Date: 5/25/17
 * Time: 17:48
 */

namespace naffiq\RocketTools\config;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ConfigGetCommand extends Command
{
    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this
            ->setName('config:get')
            ->setDescription('Shows default configurations for Rocket Tools')
            ->addArgument('config-name', InputArgument::OPTIONAL, 'Configuration key. If not set, displays all config values');
    }

    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $configName = $input->getArgument('config-name');

        $output->writeln('Displaying all config files ');

        if (empty($configName)) {
            foreach (ConfigHelper::getAll() as $key => $value) {
                $output->writeln(" - \"{$key}\" = \"{$value}\"");
            }
        } else {
            $output->writeln($configName . ' = ' . ConfigHelper::get($configName));
        }

    }
}