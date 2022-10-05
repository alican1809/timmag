<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Repository\ProductRepository;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ProductRepository $productRepository): Response
    {

        $products = $productRepository->findAll();

        return $this->render('home/index.html.twig', [
            "product1"=>$products[0],
            "product2"=>$products[2],
            "product3"=>$products[3],
        ]);
    }

}
