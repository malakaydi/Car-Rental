<?php

namespace App\Form;

use App\Entity\Tarif;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TarifType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Periode', ChoiceType::class, [
                'choices' => [
                    '1 day' => '1 day' ,
                    '3 days' => '3 days',
                    '1 week' => '1 week',
                    '2 weeks' => '2 weeks',
                    '1 month' => '1 month',
                ],
                'label' => 'Period',
                'attr' => ['class' => 'form-control'],
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
            ->add('price', TextType::class, [
                'label' => 'Price',
                'attr' => ['class' => 'form-control'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tarif::class,
        ]);
    }
}