<?php
/**
 * Created by PhpStorm.
 * User: naffiq
 * Date: 5/25/17
 * Time: 17:23
 */

namespace naffiq\RocketTools\config;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ConfigUpdateCommand
 *
 * Update config file
 *
 * @package naffiq\RocketTools\config
 */
class ConfigUpdateCommand extends Command
{
    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this
            ->setName('config:update')
            ->setDescription('Updates configurations for Rocket Tools')
            ->addArgument('config-name', InputArgument::REQUIRED, 'Configuration key')
            ->addArgument('config-value', InputArgument::REQUIRED, 'Configuration value');
    }

    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $configName = $input->getArgument('config-name');
        $configValue = $input->getArgument('config-value');

        ConfigHelper::set($configName, $configValue);

        $output->writeln('Configuration successfully updated to file ' . ConfigHelper::getConfigFile());
    }
}