<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Entity\User;
use App\Form\RegisterType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class RegisterController extends AbstractController
{
    #[Route('/inscription', name: 'app_register')]
    public function index(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $hasher, UserRepository $userRepository): Response
    {
        $user= new User();
        $form=$this->createForm(RegisterType::class, $user);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            $user = $form->getData();
            $search_email = $userRepository->findOneByEmail($user->getEmail());
     
            $password = $user->getPassword();
            $password = $hasher->hashPassword($user,$password);
            $user->setPassword($password);
            
            $entityManager->persist($user);
            $entityManager->flush();
            
            return $this->redirectToRoute('app_login');


            $mail = new Mail();
                $content = "Bonjour ".$user->getFirstname()."<br>Votre inscription s'est correctement déroulée. Vous pouvez dès à présent vous connecter à votre compte.";
                $mail->send($user->getEmail(), $user->getFirstname(), 'Bienvenue chez les Tim', $content);
                $notification = "Votre inscription c'est correctement déroulée. Vous pouvez dès à présent vous connecter à votre compte.";
        }
        else {
            $notification = "L'email deja existant ou erreur de mail.";
        }
    

        return $this->render('register/index.html.twig', [
            'form' => $form->createView(),
            'notification' =>   $notification
        ]);
    }
}
