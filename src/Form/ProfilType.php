<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
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

            ] )
            ->add('firstName',TextType::class, [
                    'label' => 'Prénom : ',

            ])
            ->add('lastName',TextType::class, [
                'label' => 'Nom : ',

            ])
            ->add('phoneNumber',NumberType::class, [
                'label' => 'Téléphone : ',

            ])

            ->add('email',EmailType::class, [
                'label' => 'Email : ',

            ])

            ->add('campus', EntityType::class, [
                'label' => 'Campus',
                'class' => Campus::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')->orderBy('c.name', 'ASC');
                },
                'choice_label' => 'name',
                'data' => $this->security->getUser()->getCampus(),
                'required' => false,
            ])

            ->add('password2', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe doivent être identiques',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => false,
                'mapped' => false,
                'first_options'  => ['label' => 'Modifier le mot de passe : '],
                'second_options' => ['label' => 'Confirmer mot de passe : '],

            ])

            ->add('profilePicture', FileType::class, [
                'mapped'=>false,
                'required'=>false
            ])


        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
