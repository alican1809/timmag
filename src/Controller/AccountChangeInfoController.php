<?php

namespace App\Controller;

use App\Classe\Mail;

use App\Form\ChangProfilInfoType;
use App\Form\ChangProfilPasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AccountChangeInfoController extends AbstractController
{
    #[Route('/compte/modifie-profil', name: 'app_account_change_info')]
    public function index(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $hasher, Mail $mail): Response
    {
        $user = $this->getUser();
        $forma = $this->createForm(ChangProfilInfoType::class, $user);
        $forma->handleRequest($request);
        if ($forma->isSubmitted() && $forma->isValid()) {
            $a = $forma->getData();
            $entityManager->flush();
        }
        $form = $this->createForm(ChangProfilPasswordType::class, $user);
        $form->handleRequest($request);
        $notif = "";

        if ($form->isSubmitted() && $form->isValid()) {
            $old_pwd = $form->get('old_password')->getData();
            
            if ($hasher->isPasswordValid($user, $old_pwd)) {

                $new_pwd = $form->get('new_password')->getData();
                $password = $hasher->hashPassword($user, $new_pwd);
                $user->setPassword($password);

                $entityManager->flush();

                $mail = new Mail();
                $content = "Bonjour".$user->getFirstname()."Votre mots de passe est mise à jour";
                $mail->send($user->getEmail(), $user->getFirstname(), 'Timmag', $content);
                
                $notif = "Votre mots de passe est mise à jour";
            } else {
                $notif = "Votre mots n'est pas a jour mise à jour retry";
            }
        }

        return $this->render('account/changeUserInfo.html.twig', [
            'form' => $form->createView(),
            'forma' => $forma->createView(),
            'notif'=>$notif
        ]);
    }
}
