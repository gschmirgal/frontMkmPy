<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\LogsRepository;
use App\Repository\LogsOracleRepository;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/admin', name: 'admin')]
class AdminController extends AbstractController{

    private function getTableColumns(TranslatorInterface $translator): array
    {
        return [
            'id' => $translator->trans('app.admin.columns.id'),
            'dateImport' => $translator->trans('app.admin.columns.date_import'),
            'dateImportFile' => $translator->trans('app.admin.columns.date_import_file'),
            'dateData' => $translator->trans('app.admin.columns.date_data'),
            'status' => $translator->trans('app.admin.columns.status')
        ];
    }

    private function getTableOracleColumns(TranslatorInterface $translator): array
    {
        return [
            'id' => $translator->trans('app.admin.columns.id'),
            'date' => $translator->trans('app.admin.columns.date'),
            'task' => $translator->trans('app.admin.columns.task'),
            'status' => $translator->trans('app.admin.columns.status')
        ];
    }

    private int $tableLimit = 20;

    #[Route('/mkmpy-logs', name: '.logs.mkmpy')]
    function mkmpylogs (Request $request, LogsRepository $repository, TranslatorInterface $translator): Response 
    {
        $tableColumns = $this->getTableColumns($translator);

        $page = $request->query->getInt('page', 1);
        $logs = $repository->paginateLogs($page, $this->tableLimit);

        $data = [];
        $tableData = [];
        foreach( $logs as $log ){
            $row = [];
            foreach (array_keys($tableColumns) as $col) {
                $getter = 'get' . ucfirst($col);
                if (method_exists($log, $getter)) {
                    $value = $log->$getter();
                    if (in_array($col, ['dateImport', 'dateImportFile'])) {
                        $value = $value?->format('Y-m-d H:i:s');
                    }elseif (in_array($col, ['dateData'])) {
                        $value = $value?->format('Y-m-d');
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
            'tableColumns' => array_values($tableColumns),
            'script' => 'MKM.py',
            'logs' => $tableData,
            'exporterPath' => 'export.log',
            'addPaginationRender' => $logs,           
        ]);
    }

    #[Route('/mkmoraclepy-logs', name: '.logs.mkmoraclepy')]
    function mkmoraclepylogs (Request $request, LogsOracleRepository $repository, TranslatorInterface $translator): Response 
    {
        $tableOracleColumns = $this->getTableOracleColumns($translator);
        
        $page = $request->query->getInt('page', 1);
        $logs = $repository->paginateLogs($page, $this->tableLimit);

        $data = [];
        $tableData = [];
        
        foreach( $logs as $log ){
            $row = [];
            //dd($log, $tableOracleColumns);
            foreach (array_keys($tableOracleColumns) as $col) {
                $getter = 'get' . ucfirst($col);
                if ($col === 'status') {
                    $value = $log->getStep()->getStep();

                } elseif ($col === 'task') {
                    $value = $log->getTask()->getTask();

                }elseif (method_exists($log, $getter)) {
                    $value = $log->$getter();
                    if (in_array($col, ['date'])) {
                        $value = $value?->format('Y-m-d H:i:s');
                    }

                } else {
                    $value = null;
                }

                $row[] = $value;
            }
            $tableData[] = $row;

        }
        //dd( $tableData );
        return $this->render('admin/logs.html.twig', [
            'tableColumns' => array_values($tableOracleColumns),
            'script' => 'MKM Oracle Py',
            'logs' => $tableData,
            'exporterPath' => 'export.logoracle',
            'addPaginationRender' => $logs,           
        ]);
    }


}