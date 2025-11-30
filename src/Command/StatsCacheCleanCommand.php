<?php

namespace App\Command;

use App\Service\StatsCacheService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:stats-cache:clean',
    description: 'Clean expired cache entries from stats_cache table',
)]
class StatsCacheCleanCommand extends Command
{
    public function __construct(
        private StatsCacheService $statsCacheService
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->info('Cleaning expired cache entries...');

        $deletedCount = $this->statsCacheService->cleanExpiredCache();

        $io->success(sprintf('Successfully deleted %d expired cache entries.', $deletedCount));

        return Command::SUCCESS;
    }
}
