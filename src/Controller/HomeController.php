<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\ExpansionsRepository;
use App\Repository\ProductsRepository;
use App\Repository\PricesRepository;

class HomeController extends AbstractController{

    #[Route('/', name: 'home')]
    function home (ExpansionsRepository $expansionsRepository, ProductsRepository $productsRepository, PricesRepository $pricesRepository): Response 
    {
        // Get statistics for the homepage
        $totalExpansions = $expansionsRepository->count([]);
        $totalCards = $productsRepository->count([]);
        $totalPrices = $pricesRepository->count([]);
        
        // Get recent expansions with card count
        $recentExpansions = $expansionsRepository->findRecentExpansionsWithCardCount(6);
        
        return $this->render('home.html.twig', [
            'totalExpansions' => $totalExpansions,
            'totalCards' => $totalCards,
            'totalPrices' => $totalPrices,
            'recentExpansions' => $recentExpansions
        ]);
    }

}