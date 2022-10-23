<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegisterType extends AbstractType
{
   
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class,[
                'label' => 'Prénom',
                 'attr' => [
                   
                    'placeholder' => 'Saisir votre Prénom ici'
                 ]
            ])
            ->add('lastname', TextType::class,[
                'label' => 'Nom',
                 'attr' => [
            
                    'placeholder' => 'Saisir votre Nom ici'
                 ]
                 
            ])
            ->add('email', EmailType::class,[
                'label' => 'Adresse mail',
                 'attr' => [
                 
                    'placeholder' => 'Saisir votre adresse mail ici'
                 ]
            ])
            ->add('password', RepeatedType::class,[
                'type' => PasswordType::class,
                'first_options' => [
                    'label' => "Mot de passe 12 caractere min",
                    'constraints' => new Length([
                        'min' => 12,
                        'max' => 30
                    ]),
    
                    'attr' =>[
                
                        'placeholder' => 'Saisir votre mode passe '
                    ]
                ],
                'second_options' => [
                    'label' => "Cofimation de Mot de passe",
                    'attr' =>[
                        
                        'placeholder' => 'Confirmer votre mode passe'
                    ]
                ]
            ])
            
            ->add('submit', SubmitType::class,[
                'label' => 'S\'inscrire',
            ])

            
        ;
    }
}
