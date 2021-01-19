<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pseudo',TextType::class, [
                // 'label' => 'Votre prénom : ',
                'attr' => [
                    'placeholder' => 'choisir un pseudo'
                ]
            ])
            ->add('email',EmailType::class, [
                'attr' => [
                    'placeholder' => 'Saisissez votre email'
                ]
            ])
            ->add('password',PasswordType::class, [
                'attr' => [
                    'placeholder' => 'Mot de passe'
                ]
            ])
            ->add('sexe', ChoiceType::class, [
                'choices' => [
                    'homme' => 'homme',
                    'femme' => 'femme',
                ],
                'expanded' => true,
                'attr' => [
                    'class' => 'd-flex flex-row flex-wrap justify-content-center align-self-center'
                ]
            ])
            ->add('age',IntegerType::class, [
                'attr' => [
                    'placeholder' => 'Age'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
