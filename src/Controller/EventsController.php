<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\CreateEventType;
use App\Form\Model\SearchData;
use App\Form\SearchFormType;
use App\Repository\EventRepository;
use App\Repository\StateRepository;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventsController extends AbstractController
{

    #[Route('/new', name: 'event_new')]
    public function new(Request $request, EntityManagerInterface $em, StateRepository $stateRepository): Response
    {
        $event = new Event();
        $eventForm = $this->createForm(CreateEventType::class, $event);

        $eventForm->handleRequest($request);

        if($eventForm->isSubmitted() && $eventForm->isValid()){

            if($eventForm->get('save')->isClicked()){
                $event->setOrganizater($this->getUser());
                $event->setState($stateRepository->findOneBy(['libelle' => 'created']));
                $event->setCampus($this->getUser()->getCampus());
                $em->persist($event);
                $em->flush();
            }
            if($eventForm->get('publish')->isClicked()){
                $event->setOrganizater($this->getUser());
                $event->setState($stateRepository->findOneBy(['libelle' => 'opened']));
                $event->setCampus($this->getUser()->getCampus());
                $em->persist($event);
                $em->flush();
            }
            if($eventForm->get('cancel')->isClicked()){
                return $this->redirectToRoute('homepage');
            }

            return $this->redirectToRoute('homepage');
        }
        return $this->render('events/new.html.twig', [
            'eventForm'=>$eventForm->createView(),
        ]);
    }

    #[Route('/accueil', name:'homepage')]
    public function searchEvents(Request $request, EventRepository $eventRepository): Response{

        $searchData = new SearchData();
        $searchForm = $this->createForm(SearchFormType::class, $searchData);
        $searchForm->handleRequest($request);


        $events = $eventRepository->findEvents($searchData, $this->getUser());

        if ($searchForm->isSubmitted() && $searchForm->isValid()){

            return $this->render('events/homepage.html.twig', [
                'events' => $events,
                'searchForm' => $searchForm->createView(),
            ]);

        }

        return $this->render('events/homepage.html.twig', [
            'searchForm' => $searchForm->createView(),
        ]);

    }


}
