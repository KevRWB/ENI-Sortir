<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class ProfilType extends AbstractType
{

    public function __construct(private Security $security)
    {
    }


    public function buildForm(FormBuilderInterface $builder, array $options): void
    {



        $builder
            ->add('pseudo',TextType::class, [
                'label' => 'Pseudo: ',
                'attr' => [
                    'value' => 'Rechercher'
                ]
            ] )
            ->add('firstName',TextType::class, [
                    'label' => 'Prénom : ',
                    'attr' => [
                        'value' => 'Rechercher'
                    ]
            ])
            ->add('lastName')
            ->add('phoneNumber')
            ->add('email')
            ->add('password')
            ->add('password')
            //->add('campus')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
