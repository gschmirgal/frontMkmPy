<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\ExpansionsRepository;
use App\Repository\ProductsRepository;
use App\Repository\PricesRepository;

class HomeController extends AbstractController{

    #[Route('/', name: 'home')]
    function home (): Response 
    {
        return $this->render('home.html.twig');
    }

}