<?php

namespace App\Form;

use App\Entity\Campus;
use App\Form\Model\SearchData;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('search',  TextType::class, [
                'label' => 'Recherche',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Rechercher'
                ]
            ])
            ->add('Campus', EntityType::class, [
                'label' => 'Campus',
                'required' => false,
                'class' => Campus::class,
                'expanded' => true,
                'multiple' => true
            ])
            ->add('startDate', DateTimeType::class, [
                'label' => 'Date début',
                'required' => false,
            ])
            ->add('endDate', DateTimeType::class, [
                'label' => 'Date fin',
                'required' => false,
            ])
//            ->add('isOrganizer')
//            ->add('isBooked')
//            ->add('isNotBooked')
//            ->add('passedEvents')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SearchData::class,
        ]);
    }
}
