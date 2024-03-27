<?php

namespace App\Form;

use App\Entity\Vidange;
use App\Entity\Voiture;
use App\Entity\HuileVoiture;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VidangeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('filtreAir', ChoiceType::class, [
            'choices' => [
                'Done' => '✅',
                'undone' => '❌️',
            ],])
            ->add('filtreHuile', ChoiceType::class, [
                'choices' => [
                    'Done' => '✅',
                    'undone' => '❌️',
                ],])
                ->add('filtreGasoil', ChoiceType::class, [
                    'choices' => [
                        'Done' => '✅',
                        'undone' => '❌️',
                    ],])
            ->add('huilVoiture')
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
            'data_class' => Vidange::class,
        ]);
    }
}
