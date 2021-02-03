<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('categorie', ChoiceType::class, [
                'placeholder' => 'Choisir une categorie',
                'choices' => array(
                    'Voir toutes les categories' => 'tout',
                    'Nature' => 'Nature',
                    'Sport' => 'Sport',
                    'Culture' => 'Culture',
                    'Sortie (soirées)' => 'Sortie',
                    'Jeux & divertissements' => 'Jeux',
                    'Autre' => 'Autre',

                ),
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
