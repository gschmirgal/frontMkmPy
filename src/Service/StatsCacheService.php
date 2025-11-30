<?php

namespace App\Service;

use App\Entity\StatsCache;
use App\Repository\StatsCacheRepository;
use App\Repository\ExpansionsRepository;
use App\Repository\ProductsRepository;
use App\Repository\PricesRepository;
use Doctrine\ORM\EntityManagerInterface;

class StatsCacheService
{
    private const CACHE_TTL_SECONDS = 3600*25; // 25 hours

    public function __construct(
        private EntityManagerInterface $entityManager,
        private StatsCacheRepository $statsCacheRepository,
        private ExpansionsRepository $expansionsRepository,
        private ProductsRepository $productsRepository,
        private PricesRepository $pricesRepository
    ) {}

    /**
     * Get homepage statistics from cache or generate them
     */
    public function getHomeStats(): array
    {
        $cacheKey = 'home_stats';

        // Try to get from cache
        $cache = $this->statsCacheRepository->findValidCache($cacheKey);

        if ($cache !== null) {
            return $cache->getCacheValue();
        }

        // Generate stats
        $stats = $this->generateHomeStats();

        // Save to cache
        $this->saveToCache($cacheKey, $stats);

        return $stats;
    }

    /**
     * Generate homepage statistics
     */
    private function generateHomeStats(): array
    {
        return [
            'totalExpansions' => $this->expansionsRepository->count([]),
            'totalCards' => $this->productsRepository->count([]),
            'totalPrices' => $this->pricesRepository->count([]),
            'recentExpansions' => $this->expansionsRepository->findRecentExpansionsWithCardCount(6)
        ];
    }

    /**
     * Save data to cache
     */
    private function saveToCache(string $cacheKey, mixed $data): void
    {
        // Check if cache entry already exists
        $cache = $this->entityManager->getRepository(StatsCache::class)
            ->findOneBy(['cacheKey' => $cacheKey]);

        if ($cache === null) {
            $cache = new StatsCache();
            $cache->setCacheKey($cacheKey);
        }

        $now = new \DateTime();
        $expiresAt = (clone $now)->modify('+' . self::CACHE_TTL_SECONDS . ' seconds');

        $cache->setCacheValue($data);
        $cache->setUpdatedAt($now);
        $cache->setExpiresAt($expiresAt);

        $this->entityManager->persist($cache);
        $this->entityManager->flush();
    }

    /**
     * Invalidate cache by key
     */
    public function invalidateCache(string $cacheKey): void
    {
        $this->statsCacheRepository->deleteCacheByKey($cacheKey);
    }

    /**
     * Invalidate all home stats cache
     */
    public function invalidateHomeStatsCache(): void
    {
        $this->invalidateCache('home_stats');
    }

    /**
     * Clean expired cache entries
     */
    public function cleanExpiredCache(): int
    {
        return $this->statsCacheRepository->deleteExpiredCache();
    }

    /**
     * Get rankings data from cache or generate them
     */
    public function getRankings(string $timeframe, string $type, bool $foil = false): array
    {
        $cacheKey = "rankings_{$type}_{$timeframe}_" . ($foil ? 'foil' : 'normal');

        // Try to get from cache
        $cache = $this->statsCacheRepository->findValidCache($cacheKey);

        if ($cache !== null) {
            return $cache->getCacheValue();
        }

        // Generate rankings
        $rankings = $this->generateRankings($timeframe, $type, $foil);

        // Save to cache
        $this->saveToCache($cacheKey, $rankings);

        return $rankings;
    }

    /**
     * Generate rankings data
     */
    private function generateRankings(string $timeframe, string $type, bool $foil): array
    {
        return match($type) {
            'gainers_absolute' => $this->pricesRepository->findTopGainersAbsolute($timeframe, 50, $foil),
            'losers_absolute' => $this->pricesRepository->findTopLosersAbsolute($timeframe, 50, $foil),
            'gainers_relative' => $this->pricesRepository->findTopGainersRelative($timeframe, 50, $foil),
            'losers_relative' => $this->pricesRepository->findTopLosersRelative($timeframe, 50, $foil),
            default => []
        };
    }

    /**
     * Invalidate all rankings cache
     */
    public function invalidateRankingsCache(): void
    {
        $types = ['gainers_absolute', 'losers_absolute', 'gainers_relative', 'losers_relative'];
        $timeframes = ['1d', '7d', '30d'];
        $variants = ['normal', 'foil'];

        foreach ($types as $type) {
            foreach ($timeframes as $timeframe) {
                foreach ($variants as $variant) {
                    $cacheKey = "rankings_{$type}_{$timeframe}_{$variant}";
                    $this->invalidateCache($cacheKey);
                }
            }
        }
    }

    /**
     * Get PricesRepository instance (for controller access)
     */
    public function getPricesRepository(): PricesRepository
    {
        return $this->pricesRepository;
    }
}
