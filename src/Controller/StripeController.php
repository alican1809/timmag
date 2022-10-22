<?php

namespace App\Controller;

use Stripe\Stripe;
use App\Classe\Cart;
use App\Classe\Mail;
use App\Entity\User;
use App\Entity\Order;
use App\Entity\Product;
use Stripe\Checkout\Session;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StripeController extends AbstractController
{


  


 





    #[Route('/commande/create-session/{reference}', name: 'app_stripe_create_session')]
    public function index(Cart $cart, EntityManagerInterface $entityManager, $reference): Response

    {

        $product_for_stripe=[];

        $YOUR_DOMAIN = 'https://timmag.herokuapp.com';
        $YOUR_DOMAIN = 'http://localhost:8000';

        $order=$entityManager->getRepository(Order::class)->findOneByReference($reference);
      
        if(!$order){
            new JsonResponse(['erro' => 'order']);
         }
         
         foreach ($order->getOrderDetails()->getValues() as $product) {
             $product_object = $entityManager->getRepository(Product::class)->findOneByName($product->getProduct());
             
             $product_for_stripe[] = [
                 'price_data' => [
                     'currency' => 'eur',
                     'unit_amount' => $product->getPrice(),
                     'product_data' => [
                         'name' => $product->getProduct(),
                         'images' => [$YOUR_DOMAIN . "/uploads/" . $product_object->getIllustration()],
                        ],
                    ],
                    'quantity' => $product->getQuantity()
                ];
            }
            
  
     

        Stripe::setApiKey('sk_test_51Lp9hfAAUBp82JtKYM22UtqMugCyf7DdEF9mquPVVCgr5RgVsxIfoRI0t6GYMqRmJwGXni5DatGat3fVZazmgr9p006ECQk8MH');


        $checkout_session = Session::create([
            'customer_email' => $this->getUser()->getEmail(),
            'line_items' => [$product_for_stripe],
            'mode' => 'payment',
            'success_url' => $YOUR_DOMAIN . '/commande/merci/{CHECKOUT_SESSION_ID}',
            'cancel_url' => $YOUR_DOMAIN . '/commande/erreur/{CHECKOUT_SESSION_ID}',
        ]);

        $order->setStripeSessionId($checkout_session->id);
        $entityManager->flush();

        $response = new JsonResponse(['id' => $checkout_session->id]);
        return $response;
    }


    // #[Route('/success', name: 'app_success')]
    // public function success( $reponse): Response

    // {

    //     $reponse;
    //     dd($reponse);
    //      if(!$order){
    //       $user=$this-> getUser();
    //       $mail = new Mail();
    //       $content = "Bonjour ".$user->getFirstname()."<br/>Timland<br>Vous remerci de vorte achat <br/>Vous avez de nouveaux Tim dans votre Collecetion  dans Mon Compte Sur le site  www.timmag.herokuapp.com  <br/>?";
    //       $mail->send($user->getEmail(), $user->getFirstname(), 'Achat TimMag', $content);}
    //     $us="e";

    //  return $this->render('stripe/success.html.twig',[
    //     "oks"=>$us
    //  ]);
    // }

    // #[Route('/cancel', name: 'app_cancel')]
    // public function cancel( ): Response

    // {
 
        

    //  return $this->render('stripe/cancel.html.twig',[
        
    //  ]);
    // }

   
}
