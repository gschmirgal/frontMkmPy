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

        if( count($expansions) === 1 && count($cards) === 0 ){
            return $this->redirectToRoute('expansion.cardlist', [
                'id' => $expansions[0]->getId(),
            ]);
        }
        if( count($cards) === 1 && count($expansions) === 0 ){
            return $this->redirectToRoute('card.expansionlist', [
                'id' => $cards[0]['id'],
            ]);
        }

        $expansionsList = [[
                'type' => 'primary',
                'content' => 'Expansions :',
            ],
            [
                'type' => 'secondary',
                'content' => count($expansions) . ' result(s)',
            ],
        ];
        foreach( $expansions as $expansion ){
            $expansionsList[] = [
                'type' => 'link',
                'content' => $expansion->getName(),
                'route' => 'expansion.cardlist',
                'routeParams' => [
                    'id' => $expansion->getId(),
                ],
            ];
        }

        $cardsList = [[
                'type' => 'primary',
                'content' => 'Cards :',
            ],
            [
                'type' => 'secondary',
                'content' => count($cards) . ' result(s)',
            ],
        ];
        foreach( $cards as $card ){
            $cardsList[] = [
                'type' => 'link',
                'content' => $card['name'],
                'route' => 'card.expansionlist',
                'routeParams' => [
                    'id' => $card['id'],
                ],
            ];
        }

        return $this->render('searchList.html.twig', [
            'search' => $search,
            'expansionsList' => $expansionsList,
            'cardsList' => $cardsList,
        ]);
    }


}