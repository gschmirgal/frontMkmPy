<?php

namespace App\Command;

use App\Service\StatsCacheService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:stats-cache:invalidate',
    description: 'Invalidate statistics cache (home and rankings)',
)]
class StatsCacheInvalidateCommand extends Command
{
    public function __construct(
        private StatsCacheService $statsCacheService
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->info('Invalidating home statistics cache...');
        $this->statsCacheService->invalidateHomeStatsCache();

        $io->info('Invalidating rankings cache...');
        $this->statsCacheService->invalidateRankingsCache();

        $io->success('All statistics cache has been invalidated successfully.');

        return Command::SUCCESS;
    }
}
