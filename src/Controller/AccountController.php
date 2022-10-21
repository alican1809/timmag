<?php

namespace App\Controller;


use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use App\Repository\OrderDetailsRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccountController extends AbstractController
{
    #[Route('/compte/collection', name: 'app_account')]
    public function index(OrderRepository $orderRepository, OrderDetailsRepository $orderDetailsRepository, ProductRepository $productRepository): Response
    {



        $myOrders = $orderRepository->findAll();
        $myOrderDetails = $orderDetailsRepository->findAll();

        $product = $productRepository->findAll();

        $myProducts = array();

        $user = $this->getUser()->getId();

        for ($i = 0; $i < count($myOrderDetails); $i++) {

            if ($myOrderDetails[$i]->getMyOrder()->getUser()->getId() === $user) {

                array_push($myProducts, $myOrderDetails[$i]->getProduct());

            }

        }



        $myCollection = array();

        for ($a = 0; $a < count($product); $a++) {

            for ($z = 0; $z < count($myProducts); $z++) {

                if ($product[$a]->getName() == $myProducts[$z]) {
                    array_push($myCollection, $product[$a]);
                }

            }

        }

        return $this->render('account/index.html.twig', [
            "collection" => $myCollection,
        ]);
    }
}
