<?php

namespace App\Repository;

use App\Entity\StatsCache;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<StatsCache>
 */
class StatsCacheRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StatsCache::class);
    }

    /**
     * Find a cache entry by key that is not expired
     */
    public function findValidCache(string $cacheKey): ?StatsCache
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.cacheKey = :key')
            ->andWhere('s.expiresAt > :now')
            ->setParameter('key', $cacheKey)
            ->setParameter('now', new \DateTime())
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Delete expired cache entries
     */
    public function deleteExpiredCache(): int
    {
        return $this->createQueryBuilder('s')
            ->delete()
            ->where('s.expiresAt < :now')
            ->setParameter('now', new \DateTime())
            ->getQuery()
            ->execute();
    }

    /**
     * Delete cache by key
     */
    public function deleteCacheByKey(string $cacheKey): int
    {
        return $this->createQueryBuilder('s')
            ->delete()
            ->where('s.cacheKey = :key')
            ->setParameter('key', $cacheKey)
            ->getQuery()
            ->execute();
    }
}
