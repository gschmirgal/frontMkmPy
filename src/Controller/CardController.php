<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\ExpansionsRepository;
use App\Repository\ProductsRepository;
use App\Repository\PricesRepository;

class CardController extends AbstractController{

    #[Route('/cards', name: 'card.list')]
    function show (Request $request, ProductsRepository $repository ): Response 
    {
        $cards = $repository->findUnique();
        return $this->render('cardList.html.twig', [
            'cards' => $cards,
        ]);
    }

    #[Route('/card/{id}', name: 'card.expansionlist', requirements: ['id' => '\d+'])]
    function showCardsExpansion (Request $request, int $id, ExpansionsRepository $repositoryExp, productsRepository $repositoryProd ): Response 
    {   
        $originalcard = $repositoryProd->find($id);
        $cards = $repositoryProd->findBy(['idMetaCard' => $originalcard->getIdMetaCard()]);
        return $this->render('cardExpansionList.html.twig', [
            'originalcard' => $originalcard,
            'cards' => $cards,
        ]);
    }

    #[Route('/card/{cardid}/{expansionid}/', name: 'card.cardlist.detail', requirements: ['expansionid' => '\d+', 'cardid' => '\d+'])]
    function showSpecificCardExpansion (Request $request, int $expansionid, int $cardid ): Response 
    {   
        return $this->redirectToRoute('expansion.cardlist.detail', [
            'expansionid' => $expansionid,
            'cardid' => $cardid,
        ]);
    }

}