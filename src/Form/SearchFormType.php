<?php

namespace App\Form;

use App\Form\Model\SearchData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('search',  TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Rechercher'
                ]
            ])
            ->add('Campus', EntityType::class, [
                'label' => false,
                'required' => false,
                'class' => Campus::class,
                'expanded' => true,
                'multiple' => true
            ])
            ->add('startDate', DateTimeType::class, [
                'label' => false,
                'required' => false,
            ])
            ->add('endDate', DateTimeType::class, [

            ])
            ->add('isOrganizer')
            ->add('isBooked')
            ->add('isNotBooked')
            ->add('passedEvents')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SearchData::class,
        ]);
    }
}
