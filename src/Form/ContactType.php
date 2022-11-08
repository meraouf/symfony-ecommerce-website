<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prenom',TextType::class,[
                'label'=>'votre prénom',
                'attr'=>[
                    'placeholder'=>'Merci de saisir votre prénom'
                ]
            ])
            ->add('nom',TextType::class,[
                'label'=>'votre Nom',
                'attr'=>[
                    'placeholder'=>'Merci de saisir votre nom'
                ]
            ])
            ->add('email',EmailType::class,[
                'label'=>'votre mail',
                'attr'=>[
                    'placeholder'=>'Merci de saisir votre Email'
                ]
            ])
            ->add('content',TextareaType::class,[
                'label'=>'votre message',
                'attr'=>[
                    'placeholder'=>'Comment pouvons-nous vous aider?'
                ]
            ])
            ->add('submit', SubmitType::class ,[
                'label'=>'Envoyer',
                'attr'=> [
                    'class'=>'btn btn-success'
                ]

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
