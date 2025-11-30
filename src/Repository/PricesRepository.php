<?php

namespace App\Repository;

use App\Entity\Prices;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 * @extends ServiceEntityRepository<Prices>
 */
class PricesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private PaginatorInterface $paginator)
    {
        parent::__construct($registry, Prices::class);
    }


    public function paginatePrices( int $cardId, int $page, int $limit): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->createQueryBuilder('p')
                ->andWhere('p.product = :cardId')
                ->orderBy('p.id', 'DESC')
                ->setParameter('cardId', $cardId),
            $page,
            $limit
        );
    }

    /**
     * Get top gainers by absolute value for a given timeframe
     *
     * @param string $timeframe '1d', '7d', or '30d'
     * @param int $limit Number of results to return
     * @param bool $foil Whether to check foil prices
     * @return array
     */
    public function findTopGainersAbsolute(string $timeframe, int $limit = 50, bool $foil = false): array
    {
        $avgField = $foil ? 'avg1_foil' : 'avg1';
        $daysBack = match($timeframe) {
            '1d' => 1,
            '7d' => 7,
            '30d' => 30,
            default => 1,
        };

        return $this->findTopByVariation($avgField, $daysBack, $limit, 'gainers', 'absolute');
    }

    /**
     * Get top losers by absolute value for a given timeframe
     */
    public function findTopLosersAbsolute(string $timeframe, int $limit = 50, bool $foil = false): array
    {
        $avgField = $foil ? 'avg1_foil' : 'avg1';
        $daysBack = match($timeframe) {
            '1d' => 1,
            '7d' => 7,
            '30d' => 30,
            default => 1,
        };

        return $this->findTopByVariation($avgField, $daysBack, $limit, 'losers', 'absolute');
    }

    /**
     * Get top gainers by relative percentage for a given timeframe
     */
    public function findTopGainersRelative(string $timeframe, int $limit = 50, bool $foil = false): array
    {
        $avgField = $foil ? 'avg1_foil' : 'avg1';
        $daysBack = match($timeframe) {
            '1d' => 1,
            '7d' => 7,
            '30d' => 30,
            default => 1,
        };

        return $this->findTopByVariation($avgField, $daysBack, $limit, 'gainers', 'relative');
    }

    /**
     * Get top losers by relative percentage for a given timeframe
     */
    public function findTopLosersRelative(string $timeframe, int $limit = 50, bool $foil = false): array
    {
        $avgField = $foil ? 'avg1_foil' : 'avg1';
        $daysBack = match($timeframe) {
            '1d' => 1,
            '7d' => 7,
            '30d' => 30,
            default => 1,
        };

        return $this->findTopByVariation($avgField, $daysBack, $limit, 'losers', 'relative');
    }

    /**
     * Core method to find top cards by price variation with smart fallback
     * Simplified approach: use window functions to get latest and historical prices in one pass
     */
    private function findTopByVariation(string $avgField, int $daysBack, int $limit, string $type, string $mode): array
    {
        $conn = $this->getEntityManager()->getConnection();

        // Get the reference date (latest date in the database)
        $latestDateResult = $conn->executeQuery("SELECT MAX(date_data) as max_date FROM prices");
        $latestDate = $latestDateResult->fetchOne();

        if (!$latestDate) {
            return [];
        }

        // Calculate target dates for comparison
        $targetDate = date('Y-m-d', strtotime($latestDate . " -$daysBack days"));
        $beforeDate = date('Y-m-d', strtotime($latestDate . " -" . ($daysBack - 1) . " days"));
        $afterDate = date('Y-m-d', strtotime($latestDate . " -" . ($daysBack + 1) . " days"));

        // Optimized query: get today's prices and historical prices in separate queries, then join in PHP
        // This is faster because we can use indexes efficiently

        // Step 1: Get all latest prices for products with valid current price
        $todaySql = "
            SELECT p.*
            FROM prices p
            WHERE p.date_data = :latestDate
              AND p.$avgField IS NOT NULL
              AND p.$avgField > 0
        ";

        $todayStmt = $conn->prepare($todaySql);
        $todayStmt->bindValue('latestDate', $latestDate);
        $todayResult = $todayStmt->executeQuery();
        $todayPrices = $todayResult->fetchAllAssociative();

        if (empty($todayPrices)) {
            return [];
        }

        // Extract product IDs
        $productIds = array_column($todayPrices, 'idProduct');

        // Step 2: Get historical prices for these products
        $historicalSql = "
            SELECT
                p.idProduct,
                p.date_data,
                p.$avgField as price
            FROM prices p
            WHERE p.idProduct IN (" . implode(',', array_map('intval', $productIds)) . ")
              AND p.date_data IN (:targetDate, :beforeDate, :afterDate)
              AND p.$avgField IS NOT NULL
              AND p.$avgField > 0
        ";

        $historicalStmt = $conn->prepare($historicalSql);
        $historicalStmt->bindValue('targetDate', $targetDate);
        $historicalStmt->bindValue('beforeDate', $beforeDate);
        $historicalStmt->bindValue('afterDate', $afterDate);
        $historicalResult = $historicalStmt->executeQuery();
        $historicalPrices = $historicalResult->fetchAllAssociative();

        // Step 3: Build a map of historical prices by product
        $priceMap = [];
        foreach ($historicalPrices as $row) {
            $productId = $row['idProduct'];
            if (!isset($priceMap[$productId])) {
                $priceMap[$productId] = [];
            }
            $priceMap[$productId][$row['date_data']] = (float)$row['price'];
        }

        // Step 4: Calculate variations and filter
        $results = [];
        foreach ($todayPrices as $todayRow) {
            $productId = $todayRow['idProduct'];
            $currentPrice = (float)$todayRow[$avgField];

            if (!isset($priceMap[$productId])) {
                continue;
            }

            $historical = $priceMap[$productId];

            // Apply fallback logic: exact -> avg(before, after) -> before -> after
            $oldPrice = null;
            if (isset($historical[$targetDate])) {
                $oldPrice = $historical[$targetDate];
            } elseif (isset($historical[$beforeDate]) && isset($historical[$afterDate])) {
                $oldPrice = ($historical[$beforeDate] + $historical[$afterDate]) / 2;
            } elseif (isset($historical[$beforeDate])) {
                $oldPrice = $historical[$beforeDate];
            } elseif (isset($historical[$afterDate])) {
                $oldPrice = $historical[$afterDate];
            }

            if ($oldPrice === null || $oldPrice == 0) {
                continue;
            }

            // Calculate variation
            $absoluteVariation = $currentPrice - $oldPrice;
            $relativeVariation = ($absoluteVariation / $oldPrice) * 100;

            // Filter based on type (gainers/losers)
            if ($type === 'gainers' && $absoluteVariation <= 0) {
                continue;
            }
            if ($type === 'losers' && $absoluteVariation >= 0) {
                continue;
            }

            $results[] = [
                'row' => $todayRow,
                'absolute' => $absoluteVariation,
                'relative' => $relativeVariation
            ];
        }

        // Step 5: Sort and limit
        $sortKey = $mode === 'absolute' ? 'absolute' : 'relative';
        usort($results, function($a, $b) use ($sortKey, $type) {
            if ($type === 'gainers') {
                return $b[$sortKey] <=> $a[$sortKey]; // DESC
            } else {
                return $a[$sortKey] <=> $b[$sortKey]; // ASC
            }
        });

        $results = array_slice($results, 0, $limit);

        if (empty($results)) {
            return [];
        }

        // Step 6: Fetch full entities with relations
        $priceIds = array_column(array_column($results, 'row'), 'id');

        $entities = $this->createQueryBuilder('p')
            ->select('p', 'prod', 'exp', 'scryfall')
            ->innerJoin('p.product', 'prod')
            ->innerJoin('prod.expansion', 'exp')
            ->leftJoin('prod.scryfall', 'scryfall')
            ->where('p.id IN (:ids)')
            ->setParameter('ids', $priceIds)
            ->getQuery()
            ->getResult();

        // Preserve sort order from results and attach variation data
        $entityMap = [];
        foreach ($entities as $entity) {
            $entityMap[$entity->getId()] = $entity;
        }

        $resultWithVariations = [];
        foreach ($results as $result) {
            $priceId = $result['row']['id'];
            if (isset($entityMap[$priceId])) {
                $currentPrice = (float)$result['row'][$avgField];
                $oldPrice = $currentPrice - $result['absolute'];

                $resultWithVariations[] = [
                    'price_id' => $priceId,
                    'current_price' => $currentPrice,
                    'old_price' => $oldPrice,
                    'variation_absolute' => $result['absolute'],
                    'variation_relative' => $result['relative'],
                ];
            }
        }

        return $resultWithVariations;
    }
}
