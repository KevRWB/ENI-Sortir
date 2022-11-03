<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\CreateEventType;
use App\Form\Model\SearchData;
use App\Form\RegistrationEventType;
use App\Form\SearchFormType;
use App\Repository\EventRepository;
use App\Repository\LocationRepository;
use App\Repository\StateRepository;
use Doctrine\ORM\EntityManagerInterface;


use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventsController extends AbstractController
{
    #[Route('/getLocationsFromCity/{id}', name: 'locations_from_city')]
    public function LocationsListOfACity( LocationRepository $locationRepository, int $id = 1)
    {

        $locations = $locationRepository->createQueryBuilder('l')
            ->where('l.city = :cityId')
            ->setParameter('cityId', $id)
            ->getQuery()
            ->getResult();

        $responseArray = array();
        foreach ($locations as $location){
            $responseArray[] = array(
                'id' => $location->getId(),
                'name' => $location->getName()
            );
        }

        return $this->json($responseArray);
    }

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


        $events = $eventRepository->findEvents($searchData);

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

    #[Route('/events/{id}', name: 'event')]
    public function eventId(Request $request, EventRepository $eventRepository, EntityManagerInterface $em, int $id): Response
    {
        $event = $eventRepository->find($id);

        //Show "register" button conditions
        $maxGoersReach = false;
        $userIsNotGoer = false;
        $userIsNotOrganizer = false;

        $canRegister = false;
        $canUnRegister = false;

        $goersList =  $event->getGoers()->getValues();

        if(count($goersList) <= $event->getMaxUsers()){
            $maxGoersReach = true;
        }

        if(!in_array($this->getUser(), $goersList)){
            $userIsNotGoer = true;
        }

        if($this->getUser()->getPseudo() != $event->getOrganizater()->getPseudo()){
            $userIsNotOrganizer = true;
        }

        if($maxGoersReach && $userIsNotGoer && $userIsNotOrganizer &&$event->getState()->getLibelle() == 'opened'){
            $canRegister = true;
        }

        //register form
        $registerForm = $this->createForm(RegistrationEventType::class, $event);
        $registerForm->handleRequest($request);

        if($registerForm->isSubmitted() && $registerForm->isValid()){

            $event->addGoer($this->getUser());
            $em->persist($event);
            $em->flush();

        }


        // Error if event doesn't exist
        if ($event === null) {
            throw $this->createNotFoundException('Cette sortie n\'existe pas');
        }

        //return statement to the view
        return $this->render('events/event.html.twig', [
            'event' => $event,
            'canRegister' => $canRegister,
            'canUnRegister' => $canUnRegister,
            'registerForm' => $registerForm->createView(),
        ]);
    }



}
