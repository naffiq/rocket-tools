<?php
namespace naffiq\RocketTools;

use Humbug\SelfUpdate\Updater;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('self-update')
            ->setDescription('Looks up for the latest release of Rocket Tools');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Checking for the latest release...');

        $updater = new Updater(null, false);
        $updater->setStrategy(Updater::STRATEGY_GITHUB);
        $updater->getStrategy()->setPackageName('naffiq/rocket-tools');
        $updater->getStrategy()->setPharName('rocket-tools.phar');
        $updater->getStrategy()->setCurrentLocalVersion('v0.1.1');
        try {
            $result = $updater->update();
            $output->writeln($result
                ? '<info>Updated to the latest version. Check it out by running</info> <question>rocket-tools --version</question>'
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