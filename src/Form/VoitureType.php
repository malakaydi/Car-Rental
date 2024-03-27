<?php

namespace App\Form;

use App\Entity\Voiture;
use App\Entity\Marque;
use App\Entity\Boite;
use App\Entity\Image;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VoitureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Matricule')
            ->add('nbrePlace')
            ->add('couleur')
            ->add('etat', ChoiceType::class, [
                'choices' => [
                    'available' => '✅',
                    'non-available' => '❌️',
                ],
            ])
            ->add('marque', EntityType::class, [
                'class' => Marque::class,
                'choice_label' => 'libellemarque', // Adjust this to the property you want to display
                'label' => 'Brand',
                'attr' => ['class' => 'form-control', 'style' => 'background-color: #2d2d2d; color: #fff;'],
            ])
            ->add('category', ChoiceType::class, [
                'choices' => [
                    'Luxury' => 'luxury',
                    'Intermediate' => 'intermediate',
                    'Economic' => 'economic',
                ],
                'label' => 'Category',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('image', EntityType::class, [
                'class' => Image::class,
                'choice_label' => 'url',
            ])
            ->add('boite', EntityType::class, [
                'class' => Boite::class,
                'choice_label' => 'typeboite', // Adjust this to the property you want to display
                'label' => 'GearBox',
                'attr' => ['class' => 'form-control', 'style' => 'background-color: #2d2d2d; color: #fff;'],
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Voiture::class,
        ]);
    }
}
