<?php

namespace App\Form\Model;

use App\Entity\Campus;

class SearchData
{

    /**
     * @var string
     */
    public ?string $search;

    /**
     * @var Campus
     */
    public ? Campus $campus ;

    /**
     * @var \DateTime
     */
    public ?\DateTime $startDate;

    /**
     * @var \DateTime
     */
    public ?\DateTime $endDate;

    /**
     * @var boolean
     */
    public ?bool $isOrganizer = false;

    /**
     * @var boolean
     */
    public ?bool $isBooked = false;

    /**
     * @var boolean
     */
    public ?bool $isNotBooked = false;

    /**
     * @var boolean
     */
    public ?bool $passedEvents = false;

    /**
     * @return string
     */
    public function getSearch(): string
    {
        return $this->search;
    }

    /**
     * @param string $search
     * @return SearchData
     */
    public function setSearch(?string $search): SearchData
    {
        $this->search = $search;
        return $this;
    }

    /**
     * @return Campus
     */
    public function getCampus(): Campus
    {
        return $this->campus;
    }

    /**
     * @param Campus $Campus
     * @return SearchData
     */
    public function setCampus(?Campus $campus): SearchData
    {
        $this->campus = $campus;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getStartDate(): \DateTime
    {
        return $this->startDate;
    }

    /**
     * @param \DateTime $startDate
     * @return SearchData
     */
    public function setStartDate(?\DateTime $startDate): SearchData
    {
        $this->startDate = $startDate;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getEndDate(): \DateTime
    {
        return $this->endDate;
    }

    /**
     * @param \DateTime $endDate
     * @return SearchData
     */
    public function setEndDate(?\DateTime $endDate): SearchData
    {
        $this->endDate = $endDate;
        return $this;
    }

    /**
     * @return bool
     */
    public function isOrganizer(): bool
    {
        return $this->isOrganizer;
    }

    /**
     * @param bool $isOrganizer
     * @return SearchData
     */
    public function setIsOrganizer(?bool $isOrganizer): SearchData
    {
        $this->isOrganizer = $isOrganizer;
        return $this;
    }

    /**
     * @return bool
     */
    public function isBooked(): bool
    {
        return $this->isBooked;
    }

    /**
     * @param bool $isBooked
     * @return SearchData
     */
    public function setIsBooked(?bool $isBooked): SearchData
    {
        $this->isBooked = $isBooked;
        return $this;
    }

    /**
     * @return bool
     */
    public function isNotBooked(): bool
    {
        return $this->isNotBooked;
    }

    /**
     * @param bool $isNotBooked
     * @return SearchData
     */
    public function setIsNotBooked(?bool $isNotBooked): SearchData
    {
        $this->isNotBooked = $isNotBooked;
        return $this;
    }

    /**
     * @return bool
     */
    public function isPassedEvents(): bool
    {
        return $this->passedEvents;
    }

    /**
     * @param bool $passedEvents
     * @return SearchData
     */
    public function setPassedEvents(?bool $passedEvents): SearchData
    {
        $this->passedEvents = $passedEvents;
        return $this;
    }



}