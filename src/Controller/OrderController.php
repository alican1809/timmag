<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\User;
use App\Entity\Order;
use App\Form\OrderType;
use App\Entity\OrderDetails;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderController extends AbstractController
{
    #[Route('/commande', name: 'app_order')]
    public function index(Cart $cart, Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $forma = $this->createForm(OrderType::class, $user);


        return $this->render('order/index.html.twig', [
            'form' => $forma->createView(),
            'cart' => $cart->getFull()
        ]);
    }


    #[Route('/commande/recapitulatif', name: 'app_order_recap')]
    public function add(Cart $cart, Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $forma = $this->createForm(OrderType::class, $user);
        $forma->handleRequest($request);



        if ($forma->isSubmitted() && $forma->isValid()) {
            $a = $forma->getData();


            $order = new Order();
            $date = new \DateTimeImmutable();
            $order->setUser($this->getUser());
            $order->setCreateAt($date);
            $order->setIsPaid(0);

            $entityManager->persist($order);

            foreach ($cart->getFull() as $product) { 
                $orderDetails = new OrderDetails();
                $orderDetails->setMyOrder($order);
                $orderDetails->setProduct($product['product']->getName());
                $orderDetails->setQuantity($product['quantity']);
                $orderDetails->setPrice($product['product']->getPrice());
                $orderDetails->setTotal($product['product']->getPrice() * $product['quantity']);
                $entityManager->persist($orderDetails);

            }
 
            $entityManager->flush();
        } else {
        }


        return $this->render('order/add.html.twig', [
            'cart' => $cart->getFull()
        ]);
    }
}
