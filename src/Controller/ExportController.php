<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use App\Repository\LogsOracleRepository;
use App\Repository\LogsRepository;
use App\Repository\PricesRepository;

#[Route('/export')]
class ExportController extends AbstractController{
        
    #[Route('/logoracle', name: 'export.logoracle')]
    function exportOracle (Request $request, LogsOracleRepository $repositoryLogs): Response 
    {
        // Récupérer les paramètres avec valeurs par défaut
        $mode = $request->query->getString('mode', "page");
        $page = $request->query->getInt('page', 1);
        $offset = $request->query->getInt('offset', 10);
        
        if( $mode == "all" ){
            $data = $repositoryLogs->findAll();

        }else{
            $pagination = $repositoryLogs->paginateLogs($page, $offset);
            $data = $pagination->getItems(); // Convertir en array

        }

        $csvContent = $this->data2csv($data, [
            'id' => 'ID',
            'date' => 'Date',
            'task.task' => 'Task Name',
        ]);

        
        // Créer la réponse avec les bons headers
        $response = new Response($csvContent);
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="logs-oracle-'.date('Y-m-d').'.csv"');
        
        return $response;
    }




    #[Route('/log', name: 'export.log')]
    function exportlog (Request $request, LogsRepository $repositoryLogs): Response 
    {
        // Récupérer les paramètres avec valeurs par défaut
        $mode = $request->query->getString('mode', "page");
        $page = $request->query->getInt('page', 1);
        $offset = $request->query->getInt('offset', 10);
        
        if( $mode == "all" ){
            $data = $repositoryLogs->findAll();

        }else{
            $pagination = $repositoryLogs->paginateLogs($page, $offset);
            $data = $pagination->getItems(); // Convertir en array

        }
        $csvContent = $this->data2csv($data, [
            'id' => 'ID',
            'dateImport' => 'Import Date',
            'dateImportFile' => 'MKM export Date',
            'dateData' => 'Data for',
            'step.step' => 'Task Name',
        ]);

        
        // Créer la réponse avec les bons headers
        $response = new Response($csvContent);
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="logs-mkm-'.date('Y-m-d').'.csv"');
        
        return $response;
    }

    #[Route('/cardPrices', name: 'export.card.prices')]
    function exportCardPrice (Request $request, PricesRepository $repositoryPrices): Response 
    {
        // Récupérer les paramètres avec valeurs par défaut
        $mode = $request->query->getString('mode', "page");
        $page = $request->query->getInt('page', 1);
        $offset = $request->query->getInt('offset', 10);
        $cardid = $request->query->getInt('cardid', 0);

        if( $cardid === 0 ){

            return new Response("Parameter 'cardid' is required", 400);
        }


        if( $mode == "all" ){
            $data = $repositoryPrices->findBy(['product' => $cardid]);

        }else{
            $prices = $repositoryPrices->paginatePrices($cardid, $page, $offset);
            $data = $prices->getItems(); // Convertir en array

        }
        $csvContent = $this->data2csv($data, [
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
        ]);

        
        // Créer la réponse avec les bons headers
        $response = new Response($csvContent);
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="cardPrices-'.$cardid.'-'.date('Y-m-d').'.csv"');
        
        return $response;
    }


    
    function data2csv(array $data, array $columns, string $splitSeparator = ";"): string {
        $csvContent = implode($splitSeparator, array_values($columns)) . "\n";

        foreach ($data as $item) {
            $row = [];
            foreach (array_keys($columns) as $col) {
                $value = $this->getNestedValue($item, $col);
                
                // Gestion des différents types de valeurs
                if ($value instanceof \DateTimeInterface) {
                    $value = $value->format('Y-m-d H:i:s');
                } elseif (is_null($value)) {
                    $value = '';
                } else {
                    $value = (string)$value;
                }
                
                $row[] = '"' . str_replace('"', '""', $value) . '"';
            }
            $csvContent .= implode($splitSeparator, $row) . "\n";
        }

        return $csvContent;
    }
    
    private function getNestedValue($object, string $path) {
        $parts = explode('.', $path);
        $current = $object;
        
        foreach ($parts as $part) {
            $getter = 'get' . ucfirst($part);
            if (method_exists($current, $getter)) {
                $current = $current->$getter();
                if (is_null($current)) {
                    return null;
                }
            } else {
                return null;
            }
        }
        
        return $current;
    }

}