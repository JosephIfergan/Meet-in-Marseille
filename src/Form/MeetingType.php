<?php

namespace App\Form;

use App\Entity\Meeting;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Constraints\IsTrue;

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
            ->add('adresse')
            ->add('description')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Meeting::class,
        ]);
    }
}
