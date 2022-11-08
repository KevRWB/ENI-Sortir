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
    public function new(Request $request, EntityManagerInterface $em, GetStates $getStates,  UpdateEventState $updateEventState): Response
    {
        $event = new Event();
        $eventForm = $this->createForm(CreateEventType::class, $event);

        $eventForm->handleRequest($request);

        if($eventForm->isSubmitted() && $eventForm->isValid()){

            if($eventForm->get('save')->isClicked()){
                $event->setOrganizater($this->getUser());
                $event->setState($getStates->getStateOpened());
                $event->setCampus($this->getUser()->getCampus());
                $updateEventState->updateEventState($getStates, $em, $event);
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
            sleep(1.5);
            return $this->redirectToRoute('homepage');

        }
        return $this->render('events/new.html.twig', [
            'eventForm'=>$eventForm->createView(),
        ]);
    }

    #[Route('/modify/{id}', name: 'event_modify')]
    public function modify(Request $request, EntityManagerInterface $em, EventRepository $eventRepository, int $id,  UpdateEventState $updateEventState, GetStates $getStates): Response
    {
        $event = $eventRepository->find($id);

        $eventForm = $this->createForm(ModifyEventType::class, $event);

        $eventForm->handleRequest($request);

        if($eventForm->isSubmitted() && $eventForm->isValid()){

            return $this->redirectToRoute('event', ['id' => $id]);
        }
        return $this->render('events/modify.html.twig', [
            'eventForm'=>$eventForm->createView(),
            'event' => $event,
        ]);
    }

    #[Route('/cancel/{id}', name: 'event_cancel')]
    public function cancel(EntityManagerInterface $em, EventRepository $eventRepository, int $id, GetStates $getStates): Response
    {

        $event = $eventRepository->find($id);
        $stateCancel = $getStates->getStateCanceled();
        $event->setState($stateCancel);
        $em->persist($event);
        $em->flush();
        return $this->redirectToRoute('event', ['id' => $id]);

    }

    #[Route('/accueil', name:'homepage')]
    public function searchEvents(Request $request, EventRepository $eventRepository, UpdateEventState $updateEventState, GetStates $getStates, EntityManagerInterface $em): Response{

        $updateEventState->updateAllState($eventRepository, $getStates, $em);

        $searchData = new SearchData();
        $searchData->setCampus($this->getUser()->getCampus());

        $allEvents =$eventRepository->findEvents($searchData);

        $searchForm = $this->createForm(SearchFormType::class, $searchData);
        $searchForm->handleRequest($request);

        if ($searchForm->isSubmitted() && $searchForm->isValid()){

            $allEvents = $eventRepository->findEvents($searchData);

            return $this->render('events/homepage.html.twig', [
                'allEvents' => $allEvents,
                'searchForm' => $searchForm->createView(),
            ]);

        }

        return $this->render('events/homepage.html.twig', [
            'searchForm' => $searchForm->createView(),
            'allEvents' => $allEvents,
        ]);
    }

    #[Route('/events/{id}', name: 'event')]
    public function eventId(Request $request, EventRepository $eventRepository, EntityManagerInterface $em, int $id, UpdateEventState $updateEventState, GetStates $getStates): Response
    {
        $event = $eventRepository->find($id);

        $updateEventState->updateAllState($eventRepository, $getStates, $em);

        // Error if event doesn't exist
        if ($event === null) {
            throw $this->createNotFoundException('Cette sortie n\'existe pas');
        }

        //return statement to the view
        return $this->render('events/event.html.twig', [
            'event' => $event,
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

    #[Route('/registerEvent/{id}', name: 'register_event')]
    public function register(int $id, EventRepository $eventRepository, EntityManagerInterface $em){

        $event = $eventRepository->find($id);

        $event->addGoer($this->getUser());
        $em->persist($event);
        $em->flush();

        return $this->redirectToRoute('event', ['id'=>$id]);

    }

    #[Route('/unRegisterEvent/{id}', name: 'unRegister_event')]
    public function unRegister(int $id, EventRepository $eventRepository, EntityManagerInterface $em){

        $event = $eventRepository->find($id);

        $event->removeGoer($this->getUser());
        $em->persist($event);
        $em->flush();

        return $this->redirectToRoute('event', ['id'=>$id]);

    }

    #[Route('/deleteEvent/{id}', name: 'delete_event')]
    public function deleteEvent ($id, EventRepository $eventRepository){

        $event = $eventRepository->find($id);

        $eventRepository->remove($event, true);

        return $this->redirectToRoute('homepage');

    }

    #[Route('/confirmDelete/{id}', name: 'confirm_delete')]
    public function confirmDelete ($id, EventRepository $eventRepository){

//        $event = $eventRepository->find($id);

        //return statement to the view
        return $this->render('security/confirm.html.twig', [
//            'event' => $event,
            'id'=>$id
        ]);

    }



}
