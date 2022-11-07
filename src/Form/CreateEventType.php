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
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
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
                'label' => 'Nom',
                'attr'=> [
                    'maxlength'=> '3',
                ]
            ])
            ->add('startDate', DateTimeType::class,[
                'widget' => 'single_text',
                'label' => 'Date et heure de la sortie',
            ])
            ->add('subscriptionLimit', DateTimeType::class,[
                'widget' => 'single_text',
                'label' => 'Date et heure limite d\'inscription',
            ])
            ->add('maxUsers', IntegerType::class, [
                'label' => 'Nombre max de participants',
            ])

            ->add('duration', TimeType::class, [
                'widget' => 'choice',
                'label' => 'Durée',
            ])

            ->add('infos', TextareaType::class, [
                'label' => 'Description'
            ])

            ->add('city', EntityType::class, [
                'class' => City::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')->orderBy('c.name', 'ASC');
                },
                'choice_label' => 'name',
                'label' => 'Ville',
                'mapped' => false,
            ])

            ->add('location', EntityType::class, [
                'class' => Location::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')->orderBy('c.city', 'ASC');
                },
                'choice_label' => 'name',
                'label' => 'Lieu',
            ])

            ->add('return', ButtonType::class, [
                'label' => 'Retour',
                'attr'=> [
                    'class' => 'btn-lg-perso'
                ]
            ])

            ->add('save', SubmitType::class, [
                'label' => 'Enregistrer',
                'attr'=> [
                    'class' => 'btn-lg-perso'
                ]
            ])

            ->add('publish', SubmitType::class, [
                'label' => 'Publier',
                'attr'=> [
                    'class' => 'btn-lg-perso'
                ]
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
