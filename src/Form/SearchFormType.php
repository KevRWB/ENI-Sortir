<?php

namespace App\Form;

use App\Entity\Campus;
use App\Form\Model\SearchData;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
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
                'label' => 'Titre contient: ',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Rechercher'
                ]
            ])
//            ->add('campus', EntityType::class, [
//                'label' => 'Campus',
//                'choice_label' => 'name',
//                'required' => false,
//                'class' => Campus::class,
//                'expanded' => true,
//                'multiple' => false
//            ])
            ->add('startDate', DateTimeType::class, [
                'label' => 'Date début',
                'required' => false,
            ])
            ->add('endDate', DateTimeType::class, [
                'label' => 'Date fin',
                'required' => false,
            ])
            ->add('isOrganizer',  CheckboxType::class, [
                'label' => 'Je suis organisateur',
                'required' => false,
            ])
            ->add('isBooked',  CheckboxType::class, [
                'label' => 'Je participe',
                'required' => false,
            ])
            ->add('isNotBooked', CheckboxType::class, [
                'label' => 'Je ne participe pas',
                'required' => false,
            ] )
            ->add('passedEvents', CheckboxType::class, [
                'label' => 'Sorties passées',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchData::class,
            'method' => 'GET',
            'csrf_protection' => false
        ]);
    }
}
