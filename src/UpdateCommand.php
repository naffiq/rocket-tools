<?php
namespace naffiq\RocketTools;

use Humbug\SelfUpdate\Strategy\GithubStrategy;
use Humbug\SelfUpdate\Updater;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('self-update')
            ->setDescription('Looks up for the latest release of Rocket Tools')
            ->addArgument('stability', InputArgument::OPTIONAL, 'Set stability (stable|unstable|any)', 'stable');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $stability = $input->getArgument('stability');

        $output->writeln('Checking for the latest release...');

        $updater = new Updater(null, false, Updater::STRATEGY_GITHUB);

        $updater->getStrategy()->setStability($stability);
        $updater->getStrategy()->setPackageName('naffiq/rocket-tools');
        $updater->getStrategy()->setPharName('rocket-tools.phar');
        $updater->getStrategy()->setCurrentLocalVersion($this->getApplication()->getVersion());

        try {
            $result = $updater->update();
            $newVersion = $updater->getNewVersion();
            $output->writeln($result
                ? "<info>Updated to the version {$newVersion}.</info>"
                : '<comment>No updates</comment>'
            );
        } catch (\Exception $e) {
            $output->writeln($e->getMessage());
            $output->writeln('<error>Oops, seems like something happened during update :(</error>');
            $output->writeln('<error>Check your internet connection or post an issue here:</error>');
            $output->writeln('<error>https://github.com/naffiq/rocket-tools/issues</error>');
        }
    }
}