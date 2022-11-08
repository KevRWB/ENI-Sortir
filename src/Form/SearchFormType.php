<?php

namespace App\Form;

use App\Entity\Campus;
use App\Form\Model\SearchData;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class SearchFormType extends AbstractType
{

    public function __construct(private Security $security)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('search',  TextType::class, [
                'label' => 'Recherche dans le titre : ',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Rechercher'
                ]
            ])

            ->add('campus', EntityType::class, [
                'label' => 'Campus : ',
                'class' => Campus::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')->orderBy('c.name', 'ASC');
                },
                'data' => $this->security->getUser()->getCampus(),
                'choice_label' => 'name',
                'required' => false,
            ])

            ->add('startDate', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Entre le :',
                'required' => false,
            ])
            ->add('endDate', DateType::class, [
                'widget' => 'single_text',
                'label' => 'et :',
                'required' => false,
            ])
            ->add('isOrganizer',  CheckboxType::class, [
                'label' => 'Je suis organisateur',
//                'data' => true,
                'required' => false,
                'attr'=>[
                    'class' => 'checkbox'
                ]
            ])
            ->add('isBooked',  CheckboxType::class, [
                'label' => 'Je participe',
//                'data' => true,
                'required' => false,
                'attr'=>[
                    'class' => 'checkbox'
                ]
            ])
            ->add('isNotBooked', CheckboxType::class, [
                'label' => 'Je ne participe pas',
//                'data' => true,
                'required' => false,
                'attr'=>[
                    'class' => 'checkbox'
                ]
            ] )
            ->add('passedEvents', CheckboxType::class, [
                'label' => 'Sorties passées',
                'required' => false,
                'attr'=>[
                    'class' => 'checkbox'
                ]
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
