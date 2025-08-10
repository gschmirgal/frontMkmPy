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
    function show (Request $request, ExpansionsRepository $repository ): Response 
    {
        $expansions = $repository->findAll();
        return $this->render('expansion/expansionList.html.twig', [
            'expansions' => $expansions,
        ]);
    }

    #[Route('/expansion/{id}', name: 'expansion.cardlist', requirements: ['id' => '\d+'])]
    function showCardsExpansion (Request $request, int $id, ExpansionsRepository $repositoryExp, productsRepository $repositoryProd ): Response 
    {   
        $expansion = $repositoryExp->find($id);
        $cards = $repositoryProd->findBy(['expansion' => $id]);
        return $this->render('expansion/expansionCardList.html.twig', [
            'expansion' => $expansion,
            'cards' => $cards,
        ]);
    }

    #[Route('/expansion/{expansionid}/{cardid}', name: 'expansion.cardlist.detail', requirements: ['expansionid' => '\d+', 'cardid' => '\d+'])]
    function showSpecificCardExpansion (Request $request, int $expansionid, int $cardid, Packages $assets, ExpansionsRepository $repositoryExp, ProductsRepository $repositoryProd, PricesRepository $repositoryPrices, ChartBuilderInterface $chartBuilder): Response 
    {   
        $expansion = $repositoryExp->find($expansionid);
        $card = $repositoryProd->find($cardid);
        $prices = $repositoryPrices->findBy(['product' => $cardid],['id' => 'DESC']);
        $scryfall = $card->getScryfall()->first(); // Assuming getScryfall() returns a Collection, we take the first item
        
        $cardArt = $scryfall ? $scryfall->getImgPngUri() : "";
        
        if(!$cardArt){
            $cardArt = $assets->getUrl('img/no_card.png');

        }

        $tableColumns = [
            'dateData'  => 'Date',
            'avg'       => 'moyenne',
            'low'       => 'plus bas',
            'trend'     => 'tendance',
            'avg1'      => 'moyenne 1 jour',
            'avg7'      => 'moyenne 7 jours',
            'avg30'     => 'moyenne 30 jours',
            'avgFoil'   => 'moyenne foil',
            'lowFoil'   => 'plus bas foil',
            'trendFoil' => 'tendance foil',
            'avg1Foil'  => 'moyenne 1 jour foil',
            'avg7Foil'  => 'moyenne 7 jours foil',
            'avg30Foil' => 'moyenne 30 jours foil',

        ];

        $data = [];

        foreach( $prices as $price ){
            $data['labels'][] = $price->getDateData()->format('Y-m-d');
            
            foreach( ['avg1', 'avg1Foil'] as $index =>$key ){
                if( !isset($data['datasets'][$index]) ){
                    $data['datasets'][$index] = [
                        'label' => $key,
                        'data' => [],
                    ];
                }
                $data['datasets'][$index]['data'][] = $price->{"get".$key}();
            }

        }

        foreach( $data['datasets'] as $index => $dataset ){
            $data['datasets'][$index]['label'] = $key;
            $data['datasets'][$index]['backgroundColor'] = 'rgb(255, 99, 132)';
            $data['datasets'][$index]['borderColor'] = 'rgb(255, 99, 132)';
        }

        


        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);
        $chart->setData($data);

        return $this->render('expansion/expansionCardListDetail.html.twig', [
            'expansion' => $expansion,
            'cardArt' => $cardArt,
            'card' => $card,
            'prices' => $prices,
            'tableColumns' => $tableColumns,
            'chart' => $chart,
        ]);
    }

}