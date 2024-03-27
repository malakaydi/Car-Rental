<?php

namespace App\Form;

use App\Entity\HuileVoiture;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HuileVoitureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('MarqueHuile')
            ->add('numHuile')
            ->add('etat', ChoiceType::class, [
                'choices' => [
                    'available' => '✅',
                    'non-available' => '❌️',
                ],])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => HuileVoiture::class,
        ]);
    }
}
