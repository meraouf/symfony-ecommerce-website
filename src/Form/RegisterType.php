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
use Symfony\Component\Validator\Constraints\Length;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname',TextType::class, [
                'label'=>'Votre prénom',
                'constraints'=> new Length([
                    'min' => 2,
                    'max' => 15,
                    'minMessage' => 'Votre prénom doit avoir au minimum {{ limit }} charactères',
                    'maxMessage' => 'Votre prénom doit avoir au maximum {{ limit }} charactères',
                    'allowEmptyString' => false,
                ]),
                'attr'=> [
                    'placeholder'=>'Veuillez saisir votre prénom']
            ])
            ->add('lastname', TextType::class, [
                'label'=>'Votre Nom',
                'constraints'=> new Length([
                    'min' => 2,
                    'max' => 15,
                    'minMessage' => 'Votre Nom doit avoir au minimum {{ limit }} charactères',
                    'maxMessage' => 'Votre Nom doit avoir au maximum {{ limit }} charactères',
                    'allowEmptyString' => false,
                ]),
                'attr'=>[
                    'placeholder'=>'Veuillez saisir votre Nom'
                ]
            ])
            ->add('email',EmailType::class, [
                'label'=>'Votre email',
                'attr'=>[
                    'placeholder'=>'Merci de saisir votre email'
                ]
            ])
            ->add('password',RepeatedType::class, [
                'type'=>PasswordType::class,
                'invalid_message'=>'le mot de passe et confirmation doivent etre identiques',
                'required'=> true,
                'first_options'=> ['label'=>'Mot de passe'],
                'second_options' => [ 'label'=> 'Confimez votre mote de passe']
            ])


            ->add('submit', SubmitType::class, [
                'label'=>"S'inscrire"
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
