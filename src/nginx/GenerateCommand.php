<?php
/**
 * Created by PhpStorm.
 * User: naffiq
 * Date: 5/25/17
 * Time: 16:00
 */

namespace naffiq\RocketTools\nginx;


use naffiq\RocketTools\config\ConfigHelper;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class GenerateCommand
 *
 * Generates nginx configuration for your projects.
 *
 * @package naffiq\RocketTools\nginx
 */
class GenerateCommand extends Command
{
    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this
            ->setName('nginx:generate')
            ->setDescription('Generates nginx config for development')
            ->addArgument(
                'server-name', InputArgument::REQUIRED,
                'Domain (server_name) for newly created app'
            )->addArgument(
                'document-root', InputArgument::OPTIONAL,
                'Document root for your project. If not set, taken from run directory', getcwd()
            )->addArgument(
                'sites-available', InputArgument::OPTIONAL,
                'Path of sites-available folder', ConfigHelper::get('nginx-sites-available', '/etc/nginx/sites-available')
            )->addArgument(
                'config-name', InputArgument::OPTIONAL,
                'File name for your config file. If not set first server-name is used'
            )->addArgument(
                'port', InputArgument::OPTIONAL,
                'Listen port.', ConfigHelper::get('nginx-port', 80)
            )->addArgument(
                'fast-cgi-pass', InputArgument::OPTIONAL,
                'Fast CGI pass.', ConfigHelper::get('fast-cgi-pass', 'unix:/var/run/php7.1-fpm.sock')
            );
    }

    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $input->setInteractive(true);

        $configPath = $this->getConfigPath($input);
        $serverName = $input->getArgument('server-name');
        $documentRoot = $input->getArgument('document-root');
        $port = $input->getArgument('port');
        $configName = $this->getConfigName($input);
        $fastCGIPass = $input->getArgument('fast-cgi-pass');

        $generator = new Generator($documentRoot, $serverName, $port, $fastCGIPass);

        $filePath = "{$configPath}/{$configName}";

        file_put_contents($filePath, $generator->getConfig());

        $output->writeln("<info>File </info><comment>{$filePath}</comment><info> successfully created</info>");
    }

    /**
     * @param InputInterface $input
     * @return mixed
     */
    protected function getConfigPath(InputInterface $input)
    {
        return rtrim($input->getArgument('sites-available'), '/');
    }

    /**
     * @param InputInterface $input
     * @return mixed|string
     */
    protected function getConfigName(InputInterface $input)
    {
        $result = $input->getArgument('config-name');
        if (empty($configName)) {
            list ($serverName) = explode(' ', $input->getArgument('server-name'));
            $result = $serverName . '.conf';
        }

        return $result;
    }
}