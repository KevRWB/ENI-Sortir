<?php

namespace App\Controller;

use App\Entity\Campus;
use App\Form\CampusType;
use App\Form\ModifyEventType;
use App\Repository\CampusRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/campus')]
class CampusController extends AbstractController
{
    #[Route('/', name: 'campus')]
    public function campus(Request $request, EntityManagerInterface $em, CampusRepository $campusRepository): Response
    {
        $campus = $campusRepository->findAll();
        $newCampus = new Campus();

        $campusForm = $this->createForm(CampusType::class, $newCampus);
        $campusForm->handleRequest($request);

        if($campusForm->isSubmitted() && $campusForm->isValid()){

            if($campusForm->get('save')->isClicked()){

                $em->persist($newCampus);
                $em->flush();
            }

            return $this->redirectToRoute('campus');
        }
        return $this->render('city_location/campus.html.twig', [
            'campus' => $campus,
            'campusForm'=>$campusForm->createView(),
        ]);
    }

    #[Route('/modify', name: 'campus_modify')]
    public function modify(Request $request, CampusRepository $campusRepository, int $id): Response
    {
        $campus = $campusRepository->find($id);
        $campusForm = $this->createForm(ModifyEventType::class, $campus);

        $campusForm->handleRequest($request);

        if($campusForm->isSubmitted() && $campusForm->isValid()){

            if($campusForm->get('modify')->isClicked()){
                return $this->redirectToRoute('campus');
            }
        }

        return $this->render('city_location/addCampus.html.twig', [
            'campusForm'=>$campusForm->createView(),
        ]);
    }

    #[Route('/add', name: 'campus_add')]
    public function addCampus(Request $request, EntityManagerInterface $em): Response
    {
        $campus = new Campus();

        $campusForm = $this->createForm(CampusType::class, $campus);

        $campusForm->handleRequest($request);

        if($campusForm->isSubmitted() && $campusForm->isValid()){

            $em->persist($campus);
            $em->flush();

            return $this->redirectToRoute('campus');
        }

        return $this->render('city_location/addCampus.html.twig', [
            'campusForm'=>$campusForm->createView(),
        ]);
    }
}
