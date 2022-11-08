<?php

namespace App\Form;

use App\Entity\Campus;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CampusType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Campus::class,
        ]);
    }

    public function index(?Campus $campus, Request $request, EntityManagerInterface $entityManager): Response
    {
        if(!$campus){
            $campus = new Campus();
        }
        $form = $this->createForm(ModifyEventType::class, $campus);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            if(!$campus->getId()){
                $entityManager->persist($campus);
            }
            $entityManager->flush();
            return $this->redirect($this->generateUrl('campus', ['id' => $campus->getId()]));
        }
        return $this->render('city_location/campus.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
