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
use App\Repository\PricesPredictRepository;


use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

// Contrôleur principal pour la gestion des cartes
class CardController extends AbstractController{
    // Liste des clés pour les datasets historiques du graphique
    private array $graphlist = [ 0 => 'avg1', 2 => 'avg1Foil'];
    // Liste des clés pour les datasets de prédiction du graphique
    private array $graphlistpredict = [1 => 'avg1Predict', 3 => 'avg1FoilPredict'];
    // Styles des courbes pour Chart.js (couleurs, dash, etc.)
    private array $graphStyle = [
            'avg1' => [
                'mkmvalue' => 'avg1',
                'label' => "not Foil",
                'borderColor' => 'rgb(255, 99, 132)', 
                'backgroundColor' => 'rgba(255, 99, 132, 0.2)'
            ],
            'avg1Predict' => [
                'mkmvalue' => 'avg1Predict',
                'label' => "not Foil Prediction",
                'borderColor' => 'rgb(255, 99, 132)', 
                'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                'borderDash' => [5, 5],
            ],
            'avg1Foil' => [
                'mkmvalue' => 'avg1Foil',
                'label' => "Foil",
                'borderColor' => 'rgba(0,200,255,1)',
                'backgroundColor' => 'rgba(0,255,255,0.3)'
            ],
            'avg1FoilPredict' => [
                'mkmvalue' => 'avg1FoilPredict',
                'label' => "Foil Prediction",
                'borderColor' => 'rgba(0,200,255,1)',
                'backgroundColor' => 'rgba(0,255,255,0.3)',
                'borderDash' => [5, 5],
            ],
        ];
    // Limite d'éléments par page pour le tableau
    private int $tableLimit = 30;
    // Colonnes du tableau d'évolution des prix
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

    // Affiche la liste des cartes disponibles
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

    // Affiche la liste des éditions pour une carte donnée
    #[Route('/card/{id}', name: 'card.expansionlist', requirements: ['id' => '\d+'])]
    function showCardsExpansion (Request $request, 
                            int $id, 
                            Packages $assets, 
                            ExpansionsRepository $repositoryExp, 
                            ProductsRepository $repositoryProd 
                        ): Response 
    {   
        $originalcard = $repositoryProd->find($id);
        $cards = $repositoryProd->findByMetaCardOrderByExpansionName($originalcard->getIdMetaCard());

        // Si une seule édition, redirige directement vers le détail
        if( count($cards) === 1 ){
            return $this->redirectToRoute('card.cardlist.detail', [
                'expansionid' => $cards[0]->getExpansion()->getId(),
                'cardid' => $cards[0]->getId(),
            ]);
        }

        foreach( $cards as $card ){
            $img = "";
            if( $card->getScryfall()->first() !== false ){
                $img = $card->getScryfall()->first()->getImgNormalUri();
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
    
    // Affiche le détail d'une carte pour une édition donnée, avec graphique et tableau
    #[Route('/card/{cardid}/{expansionid}/', name: 'card.cardlist.detail', requirements: ['expansionid' => '\d+', 'cardid' => '\d+'])]
    function showSpecificCardExpansion (Request $request, 
                                    int $expansionid, 
                                    int $cardid, 
                                    Packages $assets, 
                                    ExpansionsRepository $repositoryExp, 
                                    ProductsRepository $repositoryProd, 
                                    PricesRepository $repositoryPrices, 
                                    PricesPredictRepository $repositoryPricesPredict, 
                                    ChartBuilderInterface $chartBuilder
                                ): Response 
    {   
        // Récupération des entités principales
        $expansion = $repositoryExp->find($expansionid);
        $card = $repositoryProd->find($cardid);

        // Pagination des prix historiques
        $page = $request->query->getInt('page', 1);
        $prices = $repositoryPrices->paginatePrices($cardid, $page, $this->tableLimit);

        // Récupération des prédictions uniquement sur la première page
        $pricesPredict = [];
        if( $page == 1 )
            $pricesPredict = $repositoryPricesPredict->findBy(['product' => $cardid],['id' => 'asc']);

        // Récupération de l'illustration de la carte
        $scryfall = $card->getScryfall()->first(); // On prend la première image disponible
        $cardArt = $scryfall ? $scryfall->getImgPngUri() : $assets->getUrl('img/no_card.png');

        $data = [];
        $tableData = [];
        $flagDataGraph = [];
        // Construction des labels et datasets pour Chart.js
        foreach( $prices as $price ){
            $date = $price->getDateData()->format('Y-m-d');
            $dataGraph['labels'][] = $date;

            // Ajout des valeurs historiques pour chaque courbe
            foreach( $this->graphlist as $index =>$key ){
                if( !isset($dataGraph['datasets'][$index]) ){
                    $dataGraph['datasets'][$index] = $this->graphStyle[$key];
                    //initialisation ici de la courbe de prédiction associée
                    //permet de donner l'impression que les courbes se suivent
                    $dataGraph['datasets'][$index + 1] = 
                        $this->graphStyle[$key."Predict"] +
                        ["data" => [$date => $price->{"get".$key}()]];
                    
                }
                if( ($value = $price->{"get".$key}()) !== null ) {
                    $flagDataGraph[$key] = true;

                }
                $dataGraph['datasets'][$index]['data'][] = $price->{"get".$key}();
            }

            // Préparation des données pour le tableau
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

        foreach( $this->graphlist as $index =>$key ){
            // Si aucune donnée pour une courbe, on la supprime (ainsi que sa prédiction associée)
            if( !isset($flagDataGraph[$key]) ){
                unset( $dataGraph['datasets'][$index] );
                unset( $dataGraph['datasets'][$index + 1] );
            }
        }

        // Trie les datasets pour garantir l'ordre d'affichage
        ksort($dataGraph['datasets']);
        
        // Inverse l'ordre des données pour affichage chronologique
        foreach( $dataGraph['datasets'] as $key => $dataSet ){
            $dataGraph['datasets'][$key]['data'] = array_reverse( $dataSet['data'] );
        }
        $dataGraph['labels'] = array_reverse( $dataGraph['labels'] );

        // Ajoute les points de prédiction à la fin du graphique
        foreach( $pricesPredict as $price ){
            $date = $price->getDate()->format('Y-m-d');
            $dataGraph['labels'][] = $date;
            foreach( $this->graphlistpredict as $index =>$key ){
                if( isset( $dataGraph['datasets'][$index] ))
                    $dataGraph['datasets'][$index]['data'][$date] = $price->{"get".str_replace('Predict','',$key)}();
            }
        }

        // Réindexe les datasets pour éviter les trous d'index (Chart.js n'aime pas)
        $dataGraph['datasets'] = array_values($dataGraph['datasets']);
        
        
        // Création du graphique Chart.js
        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);
        $chart->setData($dataGraph);

        // Rendu de la page avec le graphique et le tableau
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