<?php

namespace App\Controller;

use App\Entity\Location;
use App\Form\CreateLocationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LocationController extends AbstractController
{
    #[Route('/locations/add', name: 'location_add')]
    public function locations(Request $request, EntityManagerInterface $em): Response
    {
        $location = new Location();
        $locationForm = $this->createForm(CreateLocationType::class, $location);

        $locationForm->handleRequest($request);

        if($locationForm->isSubmitted() && $locationForm->isValid()){

            $em->persist($location);
            $em->flush();

            return $this->redirectToRoute('homepage');

        }

        return $this->render('city_location/addLocation.html.twig', [
            'locationForm'=>$locationForm->createView(),
        ]);
    }
}
