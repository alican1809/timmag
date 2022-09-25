<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    #[Route('/nos-produit', name: 'app_products')]
    public function index(ProductRepository $productRepository, EntityManagerInterface $entityManager): Response
    {
        $products = $productRepository->findAll();

        // dd($products);
        return $this->render('product/index.html.twig', [
            'products' => $products
        ]);
    }
}
