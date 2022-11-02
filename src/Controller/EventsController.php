<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\CreateEventType;
use App\Form\Model\SearchData;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventsController extends AbstractController
{
//    #[Route('/accueil', name: 'homepage')]
//    public function accueil(Request $request): Response
//    {
//
//        //$request->getSession()->getFlashBag()->add('note', 'Vous devez être connecté pour accéder au site');
//        $this->denyAccessUnlessGranted('ROLE_USER');
//
//        return $this->render('events/homepage.html.twig', [
//            'controller_name' => 'EventsController',
//        ]);
//    }

    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $event = new Event();
        $eventForm = $this->createForm(CreateEventType::class, $event);

        $eventForm->handleRequest($request);
        if($eventForm->isSubmitted() && $eventForm->isValid()){
            $em->persist($event);
            $em->flush();

            return $this->redirectToRoute('homepage');
        }
        return $this->render('events/homepage.html.twig', [
            'eventForm'=>$eventForm->createView()
        ]);
    }

    #[Route('/accueil', name:'homepage')]
    public function searchEvents(Request $request, EventRepository $eventRepository): Response{

        $searchData = new SearchData();
        $searchForm = $this->createForm(CreateEventType::class, $searchData);
        $searchForm->handleRequest();


        $events = $eventRepository->findSearch($searchData);

        return $this->render('events/homepage.html.twig', [
            'events' => $events,
            'searchForm' => $searchForm->createView(),
        ]);

    }


}
