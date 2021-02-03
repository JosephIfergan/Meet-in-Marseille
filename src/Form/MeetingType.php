<?php

namespace App\Form;

use App\Entity\Meeting;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Constraints\IsTrue;

// use pour les images
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

class MeetingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('categorie', ChoiceType::class, [
                'placeholder' => 'Choisir une categorie',
                'choices' => array(
                    'Nature' => 'Nature',
                    'Sport' => 'Sport',
                    'Culture' => 'Culture',
                    'Sortie (soirées)' => 'Sortie',
                    'Jeux & divertissements' => 'Jeux',
                    'Autre' => 'Autre',

                ),
            ])
            // ->add('sousCategorie')
            ->add('sousCategorie',TextType::class, [
                'attr' => [
                    'placeholder' => 'Préciser le type d\'activité'
                ]
            ])
            ->add('UserMax',IntegerType::class, [
                'label' => "Maximum de participant",
                
                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,
                'attr' => [

                'placeholder' => 'Laisser vide si illimité'
                ]         
            ])
            ->add('date')
            ->add('adresse',TextType::class, [
                'required' => false,
                'attr' => [

                    'placeholder' => 'Laisser vide si meeting en ligne'
                    ] 
            ])
            ->add('latitude', HiddenType::class, [
            ])
            ->add('longitude', HiddenType::class, [
            ])
            ->add('description')
            ->add('photo_meeting', FileType::class, [
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
                    'placeholder' => 'Ajouter une photo pour votre meeting'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Meeting::class,
        ]);
    }
}
