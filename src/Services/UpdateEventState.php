<?php

namespace App\Services;

use App\Repository\EventRepository;
use App\Repository\StateRepository;

class UpdateEventState
{

    public function updateState(EventRepository $eventRepository, GetStates $getStates){

        $now = new \DateTime();

        $events = $eventRepository->findAll();

        foreach ($events as $event){

            if($event->getStartDate() >= $now){
                $event->setState($getStates->getStateInProgress());
            }

        }

    }



}