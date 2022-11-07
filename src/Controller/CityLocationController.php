<?php

namespace App\Controller;

use App\Entity\City;
use App\Form\CityType;
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
}
