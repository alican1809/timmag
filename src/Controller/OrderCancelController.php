<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderCancelController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/commande/erreur/{stripeSessionId}', name: 'app_order_cancel')]
    public function index($stripeSessionId)
    {
        $order = $this->entityManager->getRepository(Order::class)->findOneByStripeSessionId($stripeSessionId);

        if (!$order || $order->getUser() != $this->getUser()) {
            return $this->redirectToRoute('home');
        }

        // Envoyer un email à notre utilisateur pour lui indiquer l'échec de paiement
        $mail = new Mail();
        $content = "Bonjour ".$order->getUser()->getFirstname()."<br/Echec de paiment<br><br/>Votre commande n° " .$order->getReference() ." a échoué";
        $mail->send($order->getUser()->getEmail(), $order->getUser()->getFirstname(), 'Votre commande La TimMag est pas valide.', $content);

        return $this->render('order_cancel/index.html.twig', [
            'order' => $order
        ]);
    }
}
