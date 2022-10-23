<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Classe\Mail;
use App\Entity\Order;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class OrderSuccessController extends AbstractController
{    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/commande/merci/{stripeSessionId}', name: 'app_order_validate')]


        public function index(Cart $cart, $stripeSessionId)
        {
            $order = $this->entityManager->getRepository(Order::class)->findOneByStripeSessionId($stripeSessionId);
       
            if (!$order || $order->getUser() != $this->getUser()) {
                return $this->redirectToRoute('home');
            }
    
            if ($order->isIsPaid() == 0) {
             
                $cart->remove();
    
         
                $order->setIsPaid(1);
                $this->entityManager->flush();
    
      
                $mail = new Mail();
                $content = "Bonjour ".$order->getUser()->getFirstname()."<br/>Merci pour votre commande.<br><br/>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aperiam expedita fugiat ipsa magnam mollitia optio voluptas! Alias, aliquid dicta ducimus exercitationem facilis, incidunt magni, minus natus nihil odio quos sunt?";
                $mail->send($order->getUser()->getEmail(), $order->getUser()->getFirstname(), 'Votre commande La TimMag est bien validée.', $content);
            }
    
            return $this->render('order_success/index.html.twig', [
                'order' => $order
            ]);
        }
    
}