<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\LogsRepository;

#[Route('/admin', name: 'admin')]
class AdminController extends AbstractController{

    private array $tableColumns = [
        'id' => 'ID',
        'dateImport' => 'Date Import',
        'dateImportFile' => 'Date Import File',
        'dateData' => 'Date Data',
        'status' => 'Status'
    ];

    private int $tableLimit = 5;

    #[Route('/mkmpy-logs', name: '.logs.mkmpy')]
    function mkmpylogs (Request $request, LogsRepository $repository ): Response 
    {


        $page = $request->query->getInt('page', 1);
        $logs = $repository->paginateLogs($page, $this->tableLimit);

        //$logs = $repository->findBy([], ['id' => 'DESC']);


        $data = [];
        $tableData = [];
        foreach( $logs as $log ){
            $row = [];
            foreach (array_keys($this->tableColumns) as $col) {
                $getter = 'get' . ucfirst($col);
                if (method_exists($log, $getter)) {
                    $value = $log->$getter();
                    if (in_array($col, ['dateImport', 'dateImportFile'])) {
                        $value = $value->format('Y-m-d H:i:s');
                    }elseif (in_array($col, ['dateData'])) {
                        $value = $value->format('Y-m-d');
                    }elseif ($col === 'status') {
                        $value = $value."€";
                    }

                } elseif ($col === 'status') {
                    $value = $log->getStep()->getStep();

                } else {
                    $value = null;
                }

                $row[] = $value;
            }
            $tableData[] = $row;

        }
        return $this->render('admin/logs.html.twig', [
            'tableColumns' => array_values($this->tableColumns),
            'script' => 'MKM.py',
            'logs' => $tableData,
            'addPaginationRender' => $logs,           
        ]);
    }


}