<?php

namespace App\Form;

use App\Entity\Boite;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;


class BoiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('typeBoite', ChoiceType::class, [
            'choices' => [
                'Automatic' => 'automatic',
                'Manual' => 'manual',
            ],
            'label' => 'Gearbox Type',
            'placeholder' => 'Choose an option', // Optional
            'required' => true, // You can set it to false if not required
            'attr' => [
                'class' => 'form-control', // Add your custom classes if needed
                'style' => 'background-color: #2d2d2d; color: #fff;', // Add your custom styles if needed
            ],
        ])
    ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Boite::class,
        ]);
    }
}
