<?php

namespace App\Services;

use App\Repository\EventRepository;
use App\Repository\StateRepository;
use Container4Oy4avx\getConsole_ErrorListenerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints\Date;

class UpdateEventState
{

    public function updateState(EventRepository $eventRepository, GetStates $getStates, EntityManagerInterface $em){

        $now =  new \DateTime();
        $now = $now->add(new \DateInterval('PT1H'));

        $events = $eventRepository->findAll();
        foreach ($events as $event){
            $startDate = $event->getStartDate();
            $duration =$event->getDuration();
            $hours = $duration->format('H');
            $minutes = $duration->format('i');
            $interval = new \DateInterval('PT'.$hours.'H' . $minutes . 'M');
            $endDate = $startDate->add($interval);

            $dateArchive = $endDate->add(new \DateInterval('P1M'));
            $goersList = $event->getGoers()->getValues();
            $limitDate = $event->getSubscriptionLimit();

            if($event->getState()->getLibelle() == $getStates->getStateCanceled()->getLibelle()){
                $event->setState($getStates->getStateCanceled());
            }elseif($startDate <= $now && $endDate >= $now){
                $event->setState($getStates->getStateInProgress());
            }elseif ($now > $dateArchive){
                $event->setState(($getStates->getStateArchive()));
            }elseif ($now > $startDate){
                $event->setState(($getStates->getStatePassed()));
            }elseif ($now >  $limitDate || count($goersList) >= $event->getMaxUsers()){
                $event->setState(($getStates->getStateClosed()));
            }else{
                $event->setState(($getStates->getStateOpened()));
            }

            $em->persist($event);

        }
        $em->flush();

    }



}