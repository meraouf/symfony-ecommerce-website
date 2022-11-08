<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'disabled'=> true,
                'label'=>'Mon email'

            ])
            ->add('firstname', TextType::class, [
                'disabled'=>true,
                'label'=> 'Mon prénom'
            ])
            ->add('lastname', TextType::class, [
                'disabled'=>true,
                'label'=>'Mon Nom'
            ])
            ->add('old_password', PasswordType::class, [
                'mapped'=>false,
                'label'=>'Mon mot de passe',
                'attr'=> [
                    'placeholder'=>'Veuillez saisier le mot de passe actuel'
                ]
            ])
            ->add('new_password', RepeatedType::class,[
                'mapped'=>false,
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
            'data_class' => User::class,
        ]);
    }
}
