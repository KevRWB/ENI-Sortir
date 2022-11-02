<?php

namespace App\Form\Model;

use App\Entity\Campus;

class SearchData
{

    /**
     * @var string
     */
    public $search = '';

    /**
     * @var Campus[]
     */
    public $Campus = [];

    /**
     * @var \DateTime
     */
    public $startDate;

    /**
     * @var \DateTime
     */
    public $endDate;

    /**
     * @var boolean
     */
    public $isOrganizer = false;

    /**
     * @var boolean
     */
    public $isBooked = false;

    /**
     * @var boolean
     */
    public $isNotBooked = false;

    /**
     * @var boolean
     */
    public $passedEvents = false;
}