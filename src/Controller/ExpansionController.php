<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Asset\Packages;

use App\Repository\ExpansionsRepository;
use App\Repository\ProductsRepository;
use App\Repository\PricesRepository;


use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class ExpansionController extends AbstractController{

    #[Route('/expansions', name: 'expansion.list')]
    function show (
                Request $request, 
                ExpansionsRepository $repository ): Response 
    {
        $expansions = $repository->findBy([], ['name' => 'ASC']);

        $list = [];
        foreach( $expansions as $expansion ){
            $list[] = [
                'type' => 'link',
                'content' => $expansion->getName(),
                'route' => 'expansion.cardlist',
                'routeParams' => [
                    'id' => $expansion->getId(),
                ],
            ];
        }
        return $this->render('expansion/expansionList.html.twig', [
            'expansions' => $list,
        ]);


        return $this->render('expansion/expansionList.html.twig', [
            'expansions' => $expansions,
        ]);
    }

    #[Route('/expansion/{id}', name: 'expansion.cardlist', requirements: ['id' => '\d+'])]
    function showCardsExpansion (
                            Request $request, 
                            int $id, 
                            Packages $assets, 
                            ExpansionsRepository $repositoryExp, 
                            ProductsRepository $repositoryProd ): Response 
    {   
        $expansion = $repositoryExp->find($id);
        $cards = $repositoryProd->findByExpansionWithRelations($id);
        

        $list = [];
        foreach( $cards as $card ){
            $img = "";
            if( $card->getScryfall()->first() !== false ){
                $img = $card->getScryfall()->first()->getImgPngUri();
            }
            if( !$img ){
                $img = $assets->getUrl('img/no_card.png');
            }
            $list[] = [
                'type' => 'link',
                'content' => $card->getName(),
                'imgHover' => $img,
                'route' => 'expansion.cardlist.detail',
                'routeParams' => [
                    'expansionid' => $expansion->getId(),
                    'cardid' => $card->getId(),
                ],
            ];
        }
        return $this->render('expansion/expansionCardList.html.twig', [
            'expansion' => $expansion,
            'cards' => $list,
        ]);
    }

    #[Route('/expansion/{expansionid}/{cardid}', name: 'expansion.cardlist.detail', requirements: ['expansionid' => '\d+', 'cardid' => '\d+'])]
    function showSpecificCardExpansion (int $expansionid, int $cardid): Response 
    {   
        return $this->redirectToRoute('card.cardlist.detail', [
            'expansionid' => $expansionid,
            'cardid' => $cardid,
        ]);
    }

}