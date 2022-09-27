<?php

namespace App\Controller;

use App\Classe\Search;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    #[Route('/nos-produits', name: 'app_products')]
    public function index(ProductRepository $productRepository, EntityManagerInterface $entityManager, Request $request): Response
    {
        $products = $productRepository->findAll();

        // $search = new Search();

        // $form = $this->createForm(SearchType::class, $search );
  
        // dd($products);
        return $this->render('product/index.html.twig', [
            'products' => $products,
         // 'form' => $form->createView()
        ]);
    }

    
    #[Route('/produit/{slug}', name: 'app_product')]

    public function show( ProductRepository $productRepository, EntityManagerInterface $entityManager, $slug): Response
    {
         $product = $productRepository->findOneBySlug($slug);
        if (!$product) {
   
            return $this->redirectToRoute('app_products');
        }

        return $this->render('product/show.html.twig', [
            'product' => $product,

       
        ]);
    }
}
