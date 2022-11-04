<?php

namespace App\Services;

use App\Entity\State;
use App\Repository\StateRepository;

class getStates
{

    private $stateCreated;
    private $stateOpened;
    private $stateClosed;
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
        $this->stateClosed = $states[2];
        $this->stateInProgress = $states[3];
        $this->statePassed = $states[4];
        $this->stateCanceled = $states[5];
        $this->stateArchive = $states[6];
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

    /**
     * @return State
     */
    public function getStateClosed(): State
    {
        return $this->stateClosed;
    }




}