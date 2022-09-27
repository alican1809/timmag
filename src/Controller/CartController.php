<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    #[Route('/mon-panier', name: 'app_cart')]
    public function index(Cart $cart, EntityManagerInterface $entityManagerInterface, ProductRepository $productRepository): Response
    {

        $cartComplete = [];
if($cart->get()==null){

}else{
     foreach ($cart->get() as $id => $quantity) {
            $cartComplete[] = [
                'product' =>  $productRepository->findOneById($id),
                'quantity' => $quantity
            ];
    };

}


   

        return $this->render('cart/index.html.twig', [
            "cart" => $cartComplete
        ]);
    }









    #[Route('/cart/add/{id}', name: 'app_add_cart')]
    public function add(Cart $cart, $id): Response
    {

        $cart->add($id);

        return $this->redirectToRoute(
            'app_cart'
        );
    }








    #[Route('/cart/remove', name: 'app_remove_cart')]
    public function remove(Cart $cart): Response
    {

        $cart->remove();
        return $this->redirectToRoute(
            'app_cart'
        );
    }
}
