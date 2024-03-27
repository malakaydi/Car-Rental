<?php

namespace App\Form;

use App\Entity\Location;
use App\Entity\Client;
use App\Entity\Voiture;
use App\Entity\Tarif;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LocationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('startDate', DateType::class, [
            'widget' => 'single_text',
            'attr' => ['class' => 'form-control', 'style' => 'background-color: #2d2d2d; color: #fff;'],
            'input' => 'datetime_immutable', // Specify the input type
        ])
        ->add('endDate', DateType::class, [
            'widget' => 'single_text',
            'attr' => ['class' => 'form-control', 'style' => 'background-color: #2d2d2d; color: #fff;'],
            'input' => 'datetime_immutable', // Specify the input type
        ])
            ->add('tarif', EntityType::class, [
                'class' => Tarif::class,
                'choice_label' => 'id', // Adjust this to the property you want to display
                'label' => 'tarif',
                'attr' => ['class' => 'form-control', 'style' => 'background-color: #2d2d2d; color: #fff;'],
            ])
            ->add('client', EntityType::class, [
                'class' => Client::class,
                'choice_label' => 'nom', // Adjust this to the property you want to display
                'label' => 'Client',
                'attr' => ['class' => 'form-control', 'style' => 'background-color: #2d2d2d; color: #fff;'],
            ])
            ->add('voiture', EntityType::class, [
                'class' => Voiture::class,
                'choice_label' => 'Matricule', // Adjust this to the property you want to display
                'label' => 'Vehicle',
                'attr' => ['class' => 'form-control', 'style' => 'background-color: #2d2d2d; color: #fff;'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Location::class,
        ]);
    }
}
