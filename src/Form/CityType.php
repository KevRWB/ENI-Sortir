<?php

namespace App\Form;

use App\Entity\City;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('codePostal')
            ->add('save', SubmitType::class, ['label' => 'Save'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => City::class,
        ]);
    }

    public function index(?City $city, Request $request, EntityManagerInterface $entityManager): Response
    {
        if(!$city){
            $city = new City();
        }
        $form = $this->createForm(ModifyEventType::class, $city);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            if(!$city->getId()){
                $entityManager->persist($city);
            }
            $entityManager->flush();
            return $this->redirect($this->generateUrl('city', ['id' => $city->getId()]));
        }
        return $this->render('city_location/city.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
