<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\CreateEventType;
use App\Form\Model\SearchData;
use App\Form\ModifyEventType;
use App\Form\RegistrationEventType;
use App\Form\SearchFormType;
use App\Repository\EventRepository;
use App\Repository\LocationRepository;
use App\Repository\StateRepository;
use App\Services\GetStates;
use App\Services\UpdateEventState;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventsController extends AbstractController
{


    #[Route('/new', name: 'event_new')]
    public function new(Request $request, EntityManagerInterface $em, StateRepository $stateRepository, GetStates $getStates): Response
    {
        $event = new Event();
        $eventForm = $this->createForm(CreateEventType::class, $event);

        $eventForm->handleRequest($request);

        if($eventForm->isSubmitted() && $eventForm->isValid()){

            if($eventForm->get('save')->isClicked()){
                $event->setOrganizater($this->getUser());
                $event->setState($getStates->getStateOpened());
                $event->setCampus($this->getUser()->getCampus());
                $em->persist($event);
                $em->flush();
            }
            if($eventForm->get('publish')->isClicked()){
                $event->setOrganizater($this->getUser());
                $event->setState($getStates->getStateCreated());
                $event->setCampus($this->getUser()->getCampus());
                $em->persist($event);
                $em->flush();
            }

            return $this->redirectToRoute('homepage');
        }
        return $this->render('events/new.html.twig', [
            'eventForm'=>$eventForm->createView(),
        ]);
    }

    #[Route('/modify/{id}', name: 'event_modify')]
    public function modify(Request $request, EntityManagerInterface $em, EventRepository $eventRepository, int $id): Response
    {
        $event = $eventRepository->find($id);
        $eventForm = $this->createForm(ModifyEventType::class, $event);

        $eventForm->handleRequest($request);

        if($eventForm->isSubmitted() && $eventForm->isValid()){

            if($eventForm->get('save')->isClicked()){
                $em->persist($event);
                $em->flush();
            }
            if($eventForm->get('addCity')->isClicked()){
                return $this->redirectToRoute('city');
            }
            if($eventForm->get('addLocation')->isClicked()){
                return $this->redirectToRoute('event', ['id' => $id]);
            }



            return $this->redirectToRoute('event', ['id' => $id]);
        }
        return $this->render('events/modify.html.twig', [
            'eventForm'=>$eventForm->createView(),
        ]);
    }

    #[Route('/accueil', name:'homepage')]
    public function searchEvents(Request $request, EventRepository $eventRepository, UpdateEventState $updateEventState, GetStates $getStates, EntityManagerInterface $em): Response{

        $updateEventState->updateState($eventRepository, $getStates, $em);

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
        //$eventGoers = $eventRepository->findGoers($event);


        //Show "register" button conditions
        $maxGoersReach = false;
        $userIsNotGoer = false;
        $userIsNotOrganizer = false;

        $canRegister = false;
        $canUnRegister = false;

        $goersList =  $event->getGoers()->getValues();

        if(count($goersList) < $event->getMaxUsers()){
            $maxGoersReach = true;
        }

        if(!in_array($this->getUser(), $goersList)){
            $userIsNotGoer = true;
        }

        if($this->getUser()->getPseudo() != $event->getOrganizater()->getPseudo()){
            $userIsNotOrganizer = true;
        }

        if($maxGoersReach && $userIsNotGoer && $userIsNotOrganizer && $event->getState()->getLibelle() == 'opened'){
            $canRegister = true;
        }

        //Show "unregister" button conditions
        if(!$userIsNotGoer && $event->getState()->getLibelle() == 'opened'){
            $canUnRegister = true;
        }

        //register form
        $registerForm = $this->createForm(RegistrationEventType::class, $event);
        $registerForm->handleRequest($request);

        if($registerForm->isSubmitted() && $registerForm->isValid()){

            if($canRegister){
                $event->addGoer($this->getUser());
            }elseif ($canUnRegister){
                $event->removeGoer($this->getUser());
            }

            $em->persist($event);
            $em->flush();

            return $this->redirectToRoute('event', ['id' => $id]);
        }


        // Error if event doesn't exist
        if ($event === null) {
            throw $this->createNotFoundException('Cette sortie n\'existe pas');
        }

        //return statement to the view
        return $this->render('events/event.html.twig', [
            'event' => $event,
            //'eventGoers' => $eventGoers,
            'canRegister' => $canRegister,
            'canUnRegister' => $canUnRegister,
            'isOrganizer' => $userIsNotOrganizer,
            'registerForm' => $registerForm->createView(),
        ]);
    }

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



}
