<?php

namespace App\Services;

use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;

class UpdateEventState
{

    public function updateAllState(EventRepository $eventRepository, GetStates $getStates, EntityManagerInterface $em){

        $now =  new \DateTime();
        $now = $now->add(new \DateInterval('PT1H'));

        $events = $eventRepository->findAllEventsWithGoersAndState();

        foreach ($events as $event){

            /*Variables for each event checked*/

            $startDate = $event->getStartDate();
            $endDate = clone $startDate;

            $duration =$event->getDuration();
            $hours = $duration->format('H');
            $minutes = $duration->format('i');
            $interval = new \DateInterval('PT'.$hours.'H' . $minutes . 'M');
            $endDate->add($interval);

            $dateArchive =  clone $endDate;
            $dateArchive->add(new \DateInterval('P1M'));
            $goersList = $event->getGoers()->getValues();
            $limitDate = $event->getSubscriptionLimit();

            /*Variables Conditions*/
            $isCanceled = $event->getState()->getLibelle() == $getStates->getStateCanceled()->getLibelle();
            $isCreated = $event->getState()->getLibelle() == $getStates->getStateCreated()->getLibelle();
            $isInProgress = $startDate > $now && $endDate < $now;
            $isArchive = $now > $dateArchive;
            $isClosed = ($now >  $limitDate && $now < $endDate) || count($goersList) >= $event->getMaxUsers();
            $isPassed = $now > $endDate;

            /*Condtitions*/

            if($isCanceled){
                $event->setState($getStates->getStateCanceled());
            }elseif($isCreated){
                $event->setState($getStates->getStateCreated());
            }elseif($isInProgress){
                $event->setState($getStates->getStateInProgress());
            }elseif ($isArchive){
                $event->setState(($getStates->getStateArchive()));
            }elseif ($isClosed){
                $event->setState(($getStates->getStateClosed()));
            }elseif ($isPassed){
                $event->setState(($getStates->getStatePassed()));
            }else {
                $event->setState(($getStates->getStateOpened()));
            }

            $em->persist($event);

        }
        $em->flush();

    }

//    public function updateEventState(GetStates $getStates, EntityManagerInterface $em, Event $event){
//
//        $now =  new \DateTime();
//        $now = $now->add(new \DateInterval('PT1H'));
//
//        /*Variables for each event checked*/
//
//        $startDate = $event->getStartDate();
//        $endDate = clone $startDate;
//        $duration =$event->getDuration();
//        $hours = $duration->format('H');
//        $minutes = $duration->format('i');
//        $interval = new \DateInterval('PT'.$hours.'H' . $minutes . 'M');
//        $endDate->add($interval);
//
//        $dateArchive =  clone $endDate;
//        $dateArchive->add(new \DateInterval('P1M'));
//        $goersList = $event->getGoers()->getValues();
//        $limitDate = $event->getSubscriptionLimit();
//
//        /*Conditions*/
//        $isCanceled = $event->getState()->getLibelle() == $getStates->getStateCanceled()->getLibelle();
//        $isCreated = $event->getState()->getLibelle() == $getStates->getStateCreated()->getLibelle();
//        $isInProgress = $startDate > $now && $endDate < $now;
//        $isArchive = $now > $dateArchive;
//        $isClosed = ($now >  $limitDate && $now < $endDate) || count($goersList) >= $event->getMaxUsers();
//        $isPassed = $now > $endDate;
//
//
//        if($isCanceled){
//            $event->setState($getStates->getStateCanceled());
//        }elseif($isCreated){
//            $event->setState($getStates->getStateCreated());
//        }elseif($isInProgress){
//            $event->setState($getStates->getStateInProgress());
//        }elseif ($isArchive){
//            $event->setState(($getStates->getStateArchive()));
//        }elseif ($isClosed){
//            $event->setState(($getStates->getStateClosed()));
//        }elseif ($isPassed){
//            $event->setState(($getStates->getStatePassed()));
//        }else {
//            $event->setState(($getStates->getStateOpened()));
//        }
//
//        $em->persist($event);
//
//        $em->flush();
//    }

}