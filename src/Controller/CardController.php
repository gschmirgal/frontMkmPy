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

class CardController extends AbstractController{

    private array $graphlist = ['avg1', 'avg1Foil'];
    private array $graphStyle = [
            'avg1' => [
                'label' => "not Foil",
                'borderColor' => 'rgb(255, 99, 132)', 
                'backgroundColor' => 'rgba(255, 99, 132, 0.2)'
            ],
            'avg1Foil' => [
                'label' => "Foil",
                'borderColor' => 'rgba(0,200,255,1)',
                'backgroundColor' => 'rgba(0,255,255,0.3)'
            ],
        ];
    private int $tableLimit = 30;
    private array $tableColumns = [
            'dateData'  => 'Date',
            'avg'       => 'Average',
            'low'       => 'Lower',
            'trend'     => 'Trend',
            'avg1'      => '1 days average',
            'avg7'      => '7 days average',
            'avg30'     => '30 days average',
            'avgFoil'   => 'Average foil',
            'lowFoil'   => 'Lower foil',
            'trendFoil' => 'Trend Foil',
            'avg1Foil'  => '1 days average Foil',
            'avg7Foil'  => '7 days average Foil',
            'avg30Foil' => '30 days average Foil',
        ];

    #[Route('/cards', name: 'card.list')]
    function show (Request $request, ProductsRepository $repository ): Response 
    {
        $cards = $repository->findUnique();

        $list = [];
        foreach( $cards as $card ){
            $list[] = [
                'type' => 'link',
                'content' => $card['name'],
                'route' => 'card.expansionlist',
                'routeParams' => [
                    'id' => $card['id'],
                ],
            ];

        }
        
        return $this->render('card/cardList.html.twig', [
            'cards' => $list,
        ]);
    }

    #[Route('/card/{id}', name: 'card.expansionlist', requirements: ['id' => '\d+'])]
    function showCardsExpansion (Request $request, int $id, Packages $assets, ExpansionsRepository $repositoryExp, ProductsRepository $repositoryProd ): Response 
    {   
        $originalcard = $repositoryProd->find($id);
        $cards = $repositoryProd->findByMetaCardOrderByExpansionName($originalcard->getIdMetaCard());
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
                'content' => $card->getExpansion()->getName(),
                'imgHover' => $img,
                'route' => 'card.cardlist.detail',
                'routeParams' => [
                    'expansionid' => $card->getExpansion()->getId(),
                    'cardid' => $card->getId(),
                ],
            ];

        }

        return $this->render('card/cardExpansionList.html.twig', [
            'originalcard' => $originalcard,
            'list' => $list,
        ]);
    }

    #[Route('/card/{cardid}/{expansionid}/', name: 'card.cardlist.detail', requirements: ['expansionid' => '\d+', 'cardid' => '\d+'])]
    function showSpecificCardExpansion (Request $request, int $expansionid, int $cardid, Packages $assets, ExpansionsRepository $repositoryExp, ProductsRepository $repositoryProd, PricesRepository $repositoryPrices, ChartBuilderInterface $chartBuilder): Response 
    {   
        $expansion = $repositoryExp->find($expansionid);
        $card = $repositoryProd->find($cardid);
        //$prices = $repositoryPrices->findBy(['product' => $cardid],['id' => 'asc']);

        
        $page = $request->query->getInt('page', 1);
        $prices = $repositoryPrices->paginatePrices($cardid, $page, $this->tableLimit);


        $scryfall = $card->getScryfall()->first(); // Assuming getScryfall() returns a Collection, we take the first item
        
        $cardArt = $scryfall ? $scryfall->getImgPngUri() : "";
        
        if(!$cardArt){
            $cardArt = $assets->getUrl('img/no_card.png');

        }

        $data = [];
        $tableData = [];
        foreach( $prices as $price ){
            $dataGraph['labels'][] = $price->getDateData()->format('Y-m-d');

            foreach( $this->graphlist as $index =>$key ){
                if( !isset($dataGraph['datasets'][$index]) ){
                    $dataGraph['datasets'][$index] = $this->graphStyle[$key];
                }
                $dataGraph['datasets'][$index]['data'][] = $price->{"get".$key}();
            }

            $row = [];
            foreach (array_keys($this->tableColumns) as $col) {
                $getter = 'get' . ucfirst($col);
                if (method_exists($price, $getter)) {
                    $value = $price->$getter();
                    if ($value instanceof \DateTimeInterface) {
                        $value = $value->format('Y-m-d');
                    }elseif( $value == null) {
                        $value = '-';
                    }else{
                        $value = $value."€";
                    }
                    $row[] = $value;

                } else {
                    $row[] = null;
                }
            }
            $tableData[] = $row;

        }

        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);
        $chart->setData($dataGraph);

        return $this->render('card/cardExpansionListDetail.html.twig', [
            'expansion' => $expansion,
            'cardArt' => $cardArt,
            'card' => $card,

            'prices' => $tableData,
            'headerstable' => array_values($this->tableColumns),
            'addPaginationRender' => $prices,

            'chart' => $chart,
        ]);
    }

}