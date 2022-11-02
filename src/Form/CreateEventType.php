<?php

namespace App\Form;

use App\Entity\Event;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateEventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,[
                'label' => 'Nom'
            ])
            ->add('startDate', DateType::class,[
                'widget' => 'single_text'
            ])
            ->add('subscriptionLimit', DateType::class,[
                'widget' => 'single_text'
            ])
            ->add('maxUsers')
            ->add('duration')
            ->add('infos', TextareaType::class, [
                'label' => 'Description'
            ])

/*
            ->add('organizater')
            ->add('city')
            ->add('location')
*/
            /*
            ->add('campus')
            ->add('goers')
            ->add('state')
            */
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
