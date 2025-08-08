<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use App\Repository\ExpansionsRepository;
use App\Repository\ProductsRepository;
use App\Repository\PricesRepository;

class SearchController extends AbstractController{

    #[Route('/search', name: 'search')]
    function show (Request $request, ExpansionsRepository $repositoryExp, ProductsRepository $repositoryCards ): Response 
    {
        $search     = $request->query->get('search');
        $expansions = $repositoryExp->findByName($search);
        $cards      = $repositoryCards->findByNameUnique($search);
        return $this->render('searchList.html.twig', [
            'search' => $search,
            'expansions' => $expansions,
            'cards' => $cards,
        ]);
    }


}