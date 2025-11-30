<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\StatsCacheService;

class CacheWarmupController extends AbstractController
{
    public function __construct(
        private StatsCacheService $statsCacheService
    ) {}

    public function warmup(): JsonResponse
    {
        $startTime = microtime(true);
        $results = [];

        // 1. Invalidate all caches
        $this->statsCacheService->invalidateHomeStatsCache();
        $this->statsCacheService->invalidateRankingsCache();
        $results['invalidated'] = true;

        // 2. Warmup home stats
        $this->statsCacheService->getHomeStats();
        $results['home'] = 'generated';

        // 3. Warmup all ranking combinations
        $timeframes = ['1d', '7d', '30d'];
        $types = ['gainers_absolute', 'losers_absolute', 'gainers_relative', 'losers_relative'];
        $variants = [false, true]; // normal, foil

        foreach ($timeframes as $timeframe) {
            foreach ($types as $type) {
                foreach ($variants as $isFoil) {
                    $this->statsCacheService->getRankings($timeframe, $type, $isFoil);
                    $variantLabel = $isFoil ? 'foil' : 'normal';
                    $results['rankings'][] = "{$type}_{$timeframe}_{$variantLabel}";
                }
            }
        }

        $executionTime = round(microtime(true) - $startTime, 2);

        return new JsonResponse([
            'success' => true,
            'message' => 'Cache warmup completed successfully',
            'execution_time' => $executionTime . 's',
            'details' => $results,
        ]);
    }
}
