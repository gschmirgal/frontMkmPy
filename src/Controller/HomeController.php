<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\StatsCacheService;

class HomeController extends AbstractController{

    #[Route('/', name: 'home')]
    function home (StatsCacheService $statsCacheService): Response
    {
        // Get statistics from cache or generate them
        $stats = $statsCacheService->getHomeStats();

        return $this->render('home.html.twig', [
            'totalExpansions' => $stats['totalExpansions'],
            'totalCards' => $stats['totalCards'],
            'totalPrices' => $stats['totalPrices'],
            'recentExpansions' => $stats['recentExpansions']
        ]);
    }

}