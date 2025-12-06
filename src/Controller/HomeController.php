<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\StatsCacheService;
use App\Repository\ProductsRepository;
use App\Repository\PricesRepository;

class HomeController extends AbstractController{

    #[Route('/', name: 'home')]
    function home (Request $request, StatsCacheService $statsCacheService, ProductsRepository $productsRepository, PricesRepository $pricesRepository): Response
    {
        // Check if force refresh is requested
        $forceRefresh = $request->query->get('force') === '1';

        // Get statistics from cache or generate them
        $stats = $statsCacheService->getHomeStats($forceRefresh);

        // Get trending cards (7 days, normal, top 5 gainers and losers)
        $trendingGainersRaw = $statsCacheService->getRankings('7d', 'gainers_relative', false, $forceRefresh);
        $trendingLosersRaw = $statsCacheService->getRankings('7d', 'losers_relative', false, $forceRefresh);

        // Enrich trending data with product and expansion objects
        $trendingGainers = $this->enrichTrendingData(array_slice($trendingGainersRaw, 0, 5), $pricesRepository);
        $trendingLosers = $this->enrichTrendingData(array_slice($trendingLosersRaw, 0, 5), $pricesRepository);

        return $this->render('home.html.twig', [
            'totalExpansions' => $stats['totalExpansions'],
            'totalCards' => $stats['totalCards'],
            'totalPrices' => $stats['totalPrices'],
            'recentExpansions' => $stats['recentExpansions'],
            'trendingGainers' => $trendingGainers,
            'trendingLosers' => $trendingLosers
        ]);
    }

    private function enrichTrendingData(array $data, PricesRepository $pricesRepository): array
    {
        $result = [];

        foreach ($data as $variation) {
            // Get the Price entity with its relations
            $price = $pricesRepository->createQueryBuilder('p')
                ->select('p', 'prod', 'exp', 'scryfall')
                ->innerJoin('p.product', 'prod')
                ->innerJoin('prod.expansion', 'exp')
                ->leftJoin('prod.scryfall', 'scryfall')
                ->where('p.id = :priceId')
                ->setParameter('priceId', $variation['price_id'])
                ->getQuery()
                ->getOneOrNullResult();

            if (!$price) {
                continue;
            }

            $product = $price->getProduct();

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