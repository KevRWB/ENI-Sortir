<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\City;
use App\Entity\Event;


use App\Entity\Location;
use App\Repository\CityRepository;
use Doctrine\ORM\EntityRepository;
use http\Client\Curl\User;
use PharIo\Manifest\Application;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class CreateEventType extends AbstractType
{
    public function __construct(private Security $security)
    {
    }

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

            ->add('city', EntityType::class, [
                'class' => Campus::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')->orderBy('c.name', 'ASC');
                },
                'choice_label' => 'name',
                'mapped' => false,
                'data' => $this->security->getUser()->getCampus(),
            ])

            ->add('location', EntityType::class, [
                'class' => Location::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')->orderBy('c.city', 'ASC');
                },
                'choice_label' => 'name',
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
