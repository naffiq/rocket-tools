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

/**
 * Class ConfigGetCommand
 *
 * Shows current configurations
 *
 * @package naffiq\RocketTools\config
 */
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

        if (empty($configName)) {
            $allConfigs = ConfigHelper::getAll();

            if (!empty($allConfigs)) {
                $output->writeln('<info>Displaying all config values</info>');
                foreach ($allConfigs as $key => $value) {
                    $output->writeln("<comment>{$key}</comment> = <question> {$value} </question>");
                }
            } else {
                $output->writeln('<comment>No local configs found</comment>');
            }
        } else {
            $config = ConfigHelper::get($configName);
            if ($config !== null) {
                $output->writeln("<comment>{$configName}</comment> = <question> {$config} </question>");
            } else {
                $output->writeln("<comment>{$configName}</comment> wasn't found in your configs");
            }
        }
    }
}