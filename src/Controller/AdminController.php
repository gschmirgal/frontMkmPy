<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\LogsRepository;

#[Route('/admin', name: 'admin')]
class AdminController extends AbstractController{

    #[Route('/mkmpy-logs', name: '.logs.mkmpy')]
    function mkmpylogs (Request $request, LogsRepository $repository ): Response 
    {
        $logs = $repository->findBy([], ['id' => 'DESC']);

        return $this->render('admin/logs.html.twig', [
            'tableColumns' => ['id', 'dateImport', 'dateImportFile', 'dateData'],
            'script' => 'MKM.py',
            'logs' => $logs,
        ]);
    }


}