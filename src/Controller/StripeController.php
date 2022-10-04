<?php

namespace App\Controller;

use Stripe\Stripe;
use App\Classe\Cart;
use Stripe\Checkout\Session;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class StripeController extends AbstractController
{
    #[Route('/commande/create-session', name: 'app_stripe_create_session')]
    public function index(Cart $cart): Response



    {

        $product_for_stripe=[];

        $YOUR_DOMAIN = 'http://localhost:8000';

        foreach ($cart->getFull() as $product) {

            $product_for_stripe[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => $product['product']->getPrice(),
                    'product_data' => [
                        'name' => $product['product']->getName(),
                        'images' => [$YOUR_DOMAIN . "/uploads/" . $product['product']->getIllustration()],
                    ],
                ],
                'quantity' => $product['quantity']
            ];
        }



        Stripe::setApiKey('sk_test_51Lp9hfAAUBp82JtKYM22UtqMugCyf7DdEF9mquPVVCgr5RgVsxIfoRI0t6GYMqRmJwGXni5DatGat3fVZazmgr9p006ECQk8MH');



        $checkout_session = Session::create([
            'line_items' => [$product_for_stripe],
            'mode' => 'payment',
            'success_url' => $YOUR_DOMAIN . '/success.html',
            'cancel_url' => $YOUR_DOMAIN . '/cancel.html',
        ]);

        $reponse = new JsonResponse(['id' =>$checkout_session->id]);

        return $reponse;

    }
}
