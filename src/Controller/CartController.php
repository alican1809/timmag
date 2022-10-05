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

        return $this->render('cart/index.html.twig', [
            "cart" => $cart->getFull()
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





    #[Route('/cart/delete/{id}', name: 'app_delete_cart')]
    public function delete(Cart $cart, $id): Response
    {

        $cart->delete($id);
        return $this->redirectToRoute(
            'app_cart'
        );
    }
    
    
    
    
    #[Route('/cart/removeOne/{id}', name: 'app_removeOne_cart')]
    public function removeOne(Cart $cart, $id): Response
    {

        $cart->removeOne($id);
        return $this->redirectToRoute(
            'app_cart'
        );
    }
}
