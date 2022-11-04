<?php

namespace App\Services;

use App\Entity\State;
use App\Repository\StateRepository;

class getStates
{

    private $stateCreated;
    private $stateOpened;
    private $stateInProgress;
    private $statePassed;
    private $stateCanceled;
    private $stateArchive;

    /**
     * @param $stateCreated
     * @param $stateOpened
     * @param $stateInProgress
     * @param $statePassed
     * @param $stateCanceled
     * @param $stateArchive
     */
    public function __construct(StateRepository $stateRepository)
    {

        $states = $stateRepository->findAll();

        $this->stateCreated = $states[0];
        $this->stateOpened = $states[1];
        $this->stateInProgress = $states[2];
        $this->statePassed = $states[3];
        $this->stateCanceled = $states[4];
//        $this->stateArchive = $stateArchive;
    }

    /**
     * @return State
     */
    public function getStateCreated(): State
    {
        return $this->stateCreated;
    }

    /**
     * @return State
     */
    public function getStateOpened(): State
    {
        return $this->stateOpened;
    }

    /**
     * @return State
     */
    public function getStateInProgress(): State
    {
        return $this->stateInProgress;
    }

    /**
     * @return State
     */
    public function getStatePassed(): State
    {
        return $this->statePassed;
    }

    /**
     * @return State
     */
    public function getStateCanceled(): State
    {
        return $this->stateCanceled;
    }

    /**
     * @return mixed
     */
    public function getStateArchive()
    {
        return $this->stateArchive;
    }




}