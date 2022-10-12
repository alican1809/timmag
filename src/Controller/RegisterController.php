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
                $content = "Bonjottrujrur ".$user->getFirstname()."<br/>Bienvenue sur la première boutique dédiée au made in France.<br><br/>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aperiam expedita fugiat ipsa magnam mollitia optio voluptas! Alias, aliquid dicta ducimus exercitationem facilis, incidunt magni, minus natus nihil odio quos sunt?";
                $mail->send($user->getEmail(), $user->getFirstname(), 'Bienvenue sur La Boutique Française', $content);
                $notification = "Votre inscription s'est correctement déroulée. Vous pouvez dès à présent vous connecter à votre compte.";
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
