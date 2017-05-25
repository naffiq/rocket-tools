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
        $updater->getStrategy()->setCurrentLocalVersion('v0.1.0');
        try {
            $result = $updater->update();
            $output->writeln($result ? 'Updated to the latest version. Check it out by outputting ' : 'No updates');
            echo $result ? "Updated!\n" : "No update needed!\n";
        } catch (\Exception $e) {
            $output->writeln($e->getMessage());
            $output->writeln('Oops, seems like something happened during update :(');
            $output->writeln('Check your internet connection or post an issue here:');
            $output->writeln('https://github.com/naffiq/rocket-tools/issues');
        }
    }
}