<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\StatsCacheService;

class HomeController extends AbstractController{

    #[Route('/', name: 'home')]
    function home (Request $request, StatsCacheService $statsCacheService): Response
    {
        // Check if force refresh is requested
        $forceRefresh = $request->query->get('force') === '1';

        // Get statistics from cache or generate them
        $stats = $statsCacheService->getHomeStats($forceRefresh);

        return $this->render('home.html.twig', [
            'totalExpansions' => $stats['totalExpansions'],
            'totalCards' => $stats['totalCards'],
            'totalPrices' => $stats['totalPrices'],
            'recentExpansions' => $stats['recentExpansions']
        ]);
    }

}