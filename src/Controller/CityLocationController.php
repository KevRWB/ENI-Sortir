<?php

namespace App\Controller;

use App\Entity\City;
use App\Entity\Location;
use App\Form\CityType;
use App\Form\CreateLocationType;
use App\Form\ModifyEventType;
use App\Repository\CityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CityLocationController extends AbstractController
{
    #[Route('/city', name: 'city')]
    public function cities(Request $request, EntityManagerInterface $em, CityRepository $cityRepository): Response
    {
        $cities = $cityRepository->findAll();
        $newCity = new City();

        $cityForm = $this->createForm(CityType::class, $newCity);
        $cityForm->handleRequest($request);

        if($cityForm->isSubmitted() && $cityForm->isValid()){

            if($cityForm->get('save')->isClicked()){

                $em->persist($newCity);
                $em->flush();
            }

            return $this->redirectToRoute('city');
        }
        return $this->render('city_location/city.html.twig', [
            'cities' => $cities,
            'cityForm'=>$cityForm->createView(),
        ]);
    }

    #[Route('/city/add', name: 'city_add')]
    public function addCity(Request $request, EntityManagerInterface $em): Response
    {
        $city=new City();

        $cityForm = $this->createForm(CityType::class, $city);

        $cityForm->handleRequest($request);

        if($cityForm->isSubmitted() && $cityForm->isValid()){

            $em->persist($city);
            $em->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render('city_location/addCity.html.twig', [
            'cityForm'=>$cityForm->createView(),
        ]);
    }

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
