<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\DateTime;

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(message: 'Le nom ne peut pas être vide')]
    #[Assert\Length(min: 3, max:50, minMessage: 'Le nom doit comporter entre {{ min }} et {{ max }} caractères')]
    #[ORM\Column(length: 255)]
    private ?string $name = null;


    #[Assert\NotBlank(message: 'La date ne peut pas être vide')]
    #[Assert\Length(minMessage: 'La date doit comporter entre 3 et 50 caractères')]
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $startDate = null;


    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $duration = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $subscriptionLimit = null;


    #[Assert\NotBlank(message: 'Veillez renseigner ce champ')]
    #[Assert\Range(
        notInRangeMessage: 'Le nombre de participants doit être entre {{ min }} et {{ max }}',
        min: 1,
        max: 50,
    )]
    #[ORM\Column]
    private ?int $maxUsers = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $infos = null;

    #[ORM\ManyToOne(inversedBy: 'organizedEvents')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $organizater = null;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'goerEvents')]
    private Collection $goers;

    #[ORM\ManyToOne(inversedBy: 'events')]
    #[ORM\JoinColumn(nullable: false)]
    private ?State $state = null;

    #[ORM\ManyToOne(inversedBy: 'events')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Location $location = null;

    #[ORM\ManyToOne(inversedBy: 'events')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Campus $campus = null;

    public function __construct()
    {
        $this->goers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getDuration(): ?\DateTimeInterface
    {
        return $this->duration;
    }

    public function setDuration(\DateTimeInterface $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getSubscriptionLimit(): ?\DateTimeInterface
    {
        return $this->subscriptionLimit;
    }

    public function setSubscriptionLimit(\DateTimeInterface $subscriptionLimit): self
    {
        $this->subscriptionLimit = $subscriptionLimit;

        return $this;
    }

    public function getMaxUsers(): ?int
    {
        return $this->maxUsers;
    }

    public function setMaxUsers(int $maxUsers): self
    {
        $this->maxUsers = $maxUsers;

        return $this;
    }

    public function getInfos(): ?string
    {
        return $this->infos;
    }

    public function setInfos(string $infos): self
    {
        $this->infos = $infos;

        return $this;
    }

    public function getOrganizater(): ?User
    {
        return $this->organizater;
    }

    public function setOrganizater(?User $organizater): self
    {
        $this->organizater = $organizater;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getGoers(): Collection
    {
        return $this->goers;
    }

    public function addGoer(User $goer): self
    {
        if (!$this->goers->contains($goer)) {
            $this->goers->add($goer);
            $goer->addGoerEvent($this);
        }

        return $this;
    }

    public function removeGoer(User $goer): self
    {
        if ($this->goers->removeElement($goer)) {
            $goer->removeGoerEvent($this);
        }

        return $this;
    }

    public function getState(): ?State
    {
        return $this->state;
    }

    public function setState(?State $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getCampus(): ?Campus
    {
        return $this->campus;
    }

    public function setCampus(?Campus $campus): self
    {
        $this->campus = $campus;

        return $this;
    }

    /**
     * @param DateTime $dateTime
     */
    public function transform(DateTime $dateTime): int
    {
        if(!$dateTime === null)
        {
            return (new DateTime('now'))->getTimestamp();
        }
        return $dateTime->getTimestamp();
    }

    public function reverseTransform($timestamp): DateTime
    {
        return (new DateTime())->setTimestamp($timestamp);
    }
}
