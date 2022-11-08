<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResetPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('new_password', RepeatedType::class,[
                'invalid_message'=>'Le mot de passe et confirmation doivent etre identiques',
                'type'=>PasswordType::class,
                'required'=>true,
                'first_options'=>[
                    'label'=>'Nouveau mot de passe',
                    'attr'=>[
                        'placeholder'=>'Veuillez saisir votre nouveau mot de passe'
                    ]
                ],
                'second_options'=> [
                    'label'=>'Confirmer mot de passe',
                    'attr'=>[
                        'placeholder'=>'Veuillez confirmer le mot de passe'
                    ]
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label'=>'Mettre à jour'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
