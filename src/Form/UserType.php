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
// use pour les images
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;




class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pseudo',TextType::class, [
                // 'label' => 'Votre prénom : ',
                'attr' => [
                    'placeholder' => 'Choisir un pseudo'
                ]
            ])
            ->add('email',EmailType::class, [
                'attr' => [
                    'placeholder' => 'Saisissez votre email'
                ]
            ])
            // ->add('password',PasswordType::class, [
            //     'attr' => [
            //         'placeholder' => 'Mot de passe'
            //     ]
            // ])
            // ->add('sexe', ChoiceType::class, [
            //     'choices' => [
            //         'un homme' => 'homme',
            //         'une femme' => 'femme',
            //     ],
            //     'expanded' => true,
            //     'attr' => [
            //         'class' => 'd-flex flex-row flex-wrap justify-content-center align-self-center'
            //     ]
            // ])
            ->add('age',IntegerType::class, [
                'attr' => [
                    'placeholder' => 'Votre age'
                ]
            ])
            ->add('photo', FileType::class, [
                'label' => 'photo à uploader',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '10240k',      // 10 Mo ?
                        'mimeTypes' => [
                            'image/*',              // SEULEMENT DES IMAGES
                        ],
                        'mimeTypesMessage' => 'Seulement un fichier image...',
                    ])
                ],
                'attr' => [
                    'placeholder' => 'Ajouter une photo de profil'
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
