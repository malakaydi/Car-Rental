<?php

namespace App\Form;

use App\Entity\Papier;
use App\Entity\Voiture;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PapierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('voiture', EntityType::class, [
            'class' => Voiture::class,
            'choice_label' => 'Matricule',
            'label' => 'Vehicle',
            'attr' => ['class' => 'form-control', 'style' => 'background-color: #2d2d2d; color: #fff;'],
        ])
        ->add('DateValidation', DateType::class, [
            'widget' => 'single_text',
            'attr' => ['class' => 'datepicker'],
            'input' => 'datetime_immutable',
        ])
        ->add('ExpiresAt', DateType::class, [
            'widget' => 'single_text',
            'attr' => ['class' => 'datepicker'],
            'input' => 'datetime_immutable',
        ])
        ->add('etat', ChoiceType::class, [
            'choices' => [
                'valid' => '✅',
                'non-valid' => '❌️',
            ],
        ])
        ->add('TypePapier', ChoiceType::class, [
            'choices' => [
                'Insurance' => 'insurance',
                'Tax Stamp' => 'tax_stamp',
                'Thumbnail' => 'thumbnail',
            ],
            'placeholder' => 'Select TypePapier',
            'required' => true,
        ]);
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Papier::class,
        ]);
    }
}
