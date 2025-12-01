<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\Translation\TranslatorInterface;
use App\Service\StatsCacheService;

class RankingController extends AbstractController
{
    public function __construct(
        private StatsCacheService $statsCacheService,
        private TranslatorInterface $translator
    ) {}

    #[Route('/rankings', name: 'app_rankings')]
    public function index(Request $request): Response
    {
        $timeframe = $request->query->get('timeframe', '1d');
        $foil = $request->query->get('foil', 'normal');
        $isFoil = $foil === 'foil';
        $forceRefresh = $request->query->get('force') === '1';

        // Validate timeframe
        if (!in_array($timeframe, ['1d', '7d', '30d'])) {
            $timeframe = '1d';
        }

        // Get all rankings for the selected timeframe
        $gainersAbsolute = $this->statsCacheService->getRankings($timeframe, 'gainers_absolute', $isFoil, $forceRefresh);
        $losersAbsolute = $this->statsCacheService->getRankings($timeframe, 'losers_absolute', $isFoil, $forceRefresh);
        $gainersRelative = $this->statsCacheService->getRankings($timeframe, 'gainers_relative', $isFoil, $forceRefresh);
        $losersRelative = $this->statsCacheService->getRankings($timeframe, 'losers_relative', $isFoil, $forceRefresh);

        // Prepare data for the view
        $rankings = [
            'gainers' => [
                'absolute' => $this->prepareRankingData($gainersAbsolute, $timeframe, $isFoil),
                'relative' => $this->prepareRankingData($gainersRelative, $timeframe, $isFoil, true),
            ],
            'losers' => [
                'absolute' => $this->prepareRankingData($losersAbsolute, $timeframe, $isFoil),
                'relative' => $this->prepareRankingData($losersRelative, $timeframe, $isFoil, true),
            ],
        ];

        return $this->render('ranking/index.html.twig', [
            'timeframe' => $timeframe,
            'foil' => $foil,
            'rankings' => $rankings,
        ]);
    }

    /**
     * Prepare ranking data for display
     */
    private function prepareRankingData(array $pricesData, string $timeframe, bool $isFoil, bool $isRelative = false): array
    {
        if (empty($pricesData)) {
            return [];
        }

        // Extract price IDs and variation data from cached/fresh data
        $priceIds = [];
        $variationMap = [];

        foreach ($pricesData as $data) {
            $priceId = $data['price_id'];
            $priceIds[] = $priceId;
            $variationMap[$priceId] = [
                'current_price' => $data['current_price'],
                'old_price' => $data['old_price'],
                'variation_absolute' => $data['variation_absolute'],
                'variation_relative' => $data['variation_relative'],
            ];
        }

        // Fetch fresh entities with relations
        $pricesRepository = $this->statsCacheService->getPricesRepository();
        $entities = $pricesRepository->createQueryBuilder('p')
            ->select('p', 'prod', 'exp', 'scryfall')
            ->innerJoin('p.product', 'prod')
            ->innerJoin('prod.expansion', 'exp')
            ->leftJoin('prod.scryfall', 'scryfall')
            ->where('p.id IN (:ids)')
            ->setParameter('ids', $priceIds)
            ->getQuery()
            ->getResult();

        // Map entities by ID
        $entityMap = [];
        foreach ($entities as $entity) {
            $entityMap[$entity->getId()] = $entity;
        }

        // Build result array preserving the original order
        $result = [];
        foreach ($priceIds as $priceId) {
            if (!isset($entityMap[$priceId]) || !isset($variationMap[$priceId])) {
                continue;
            }

            $priceEntity = $entityMap[$priceId];
            $product = $priceEntity->getProduct();

            if (!$product) {
                continue;
            }

            $variation = $variationMap[$priceId];

            // Get Scryfall image
            $scryfallProducts = $product->getScryfall();
            $imageUrl = null;
            if ($scryfallProducts->count() > 0) {
                $scryfallProduct = $scryfallProducts->first();
                $imageUrl = $scryfallProduct->getImgNormalUri();
            }

            $result[] = [
                'product' => $product,
                'expansion' => $product->getExpansion(),
                'currentPrice' => $variation['current_price'],
                'oldPrice' => $variation['old_price'],
                'variationAbs' => $variation['variation_absolute'],
                'variationPct' => $variation['variation_relative'],
                'imageUrl' => $imageUrl,
            ];
        }

        return $result;
    }
}
