<?php

namespace App\Services;

use App\Repository\EventRepository;
use App\Repository\StateRepository;

class UpdateEventState
{

    public function updateState(EventRepository $eventRepository, StateRepository $stateRepository){

        $now = new \DateTime();

        $events = $eventRepository->findAll();
        $states = $stateRepository->findAll();


        dd($states);

        foreach ($events as $event){

            if($event->getStartDate() >= $now){
                $event->setState('inProgresse');
            }

        }

    }



}