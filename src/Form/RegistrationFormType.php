<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsFalse;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email',EmailType::class, [
                'label' => false, // je cache le label dans le formulaire
                'attr' => [
                    'placeholder' => 'Saisis ton email',
                    'class' => 'text-white !important'
                ],

            ])
           /* ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter nos termes pour pouvoir profiter de MeetInMarseille.',
                    ]),
                ],
            ]) */
            ->add('pseudo',TextType::class, [
                'attr' => [
                    'placeholder' => 'Choisis un pseudo',
                    'class' => 'text-white !important'
                ]
            ])
            ->add('sexe', ChoiceType::class, [
                'choices' => [
                    'Un homme' => 'Homme',
                    'Une femme' => 'Femme',
                ],
                'expanded' => true,
                'attr' => [
                    'class' => 'd-flex flex-row flex-wrap align-self-center mb-3'
                ]
            ])
            ->add('age',IntegerType::class, [
                'label' => false, // je cache le label dans le formulaire
                'attr' => [
                    'placeholder' => 'Ton âge',
                    'class' => 'text-white !important'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de renseigner ton âge',
                    ]),
                ]
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'label' => false, // je cache le label dans le formulaire
                'mapped' => false,
                'attr' => [
                    'placeholder' => 'Mot de passe',
                    'class' => 'text-white !important'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Choisis un mot de passe ',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Attention, ton mot de passe doit contenir au moins {{ limit }} charactères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
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
