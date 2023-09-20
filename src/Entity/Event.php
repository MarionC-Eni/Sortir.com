<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
//use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $idEvent = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATETIMETZ_MUTABLE)]
    private ?\DateTimeInterface $dateHourStart = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $duration = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateLimitInscription = null;

//    #[Assert\Range(min: 0, max: 15,
//        minMessage: "ne peux pas etre négatif",
//        maxMessage: "nombre max de participant !",
//    )]
    #[ORM\Column]
    private ?int $NbInscriptionsMax = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $infosEvent = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $ReasonCancellation = null;

    #[ORM\ManyToOne(inversedBy: 'events')]
    private ?Campus $schoolsite = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'registredevents')]
    private Collection $userregistred;

    #[ORM\ManyToOne(inversedBy: 'eventslocation')]
    private ?Location $locationevent = null;

    #[ORM\ManyToOne(inversedBy: 'statesevent')]
    private ?State $eventstate = null;

    #[ORM\ManyToOne(inversedBy: 'organizedby')]
    private ?User $eventorgenazedby = null;

    public function __construct()
    {
        $this->userregistred = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdEvent(): ?int
    {
        return $this->idEvent;
    }

    public function setIdEvent(int $idEvent): static
    {
        $this->idEvent = $idEvent;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDateHourStart(): ?\DateTimeInterface
    {
        return $this->dateHourStart;
    }

    public function setDateHourStart(\DateTimeInterface $dateHourStart): static
    {
        $this->dateHourStart = $dateHourStart;

        return $this;
    }

    public function getDuration(): ?\DateTimeInterface
    {
        return $this->duration;
    }

    public function setDuration(\DateTimeInterface $duration): static
    {
        $this->duration = $duration;

        return $this;
    }

    public function getDateLimitInscription(): ?\DateTimeInterface
    {
        return $this->dateLimitInscription;
    }

    public function setDateLimitInscription(\DateTimeInterface $dateLimitInscription): static
    {
        $this->dateLimitInscription = $dateLimitInscription;

        return $this;
    }

    public function getNbInscriptionsMax(): ?int
    {
        return $this->NbInscriptionsMax;
    }

    public function setNbInscriptionsMax(int $NbInscriptionsMax): static
    {
        $this->NbInscriptionsMax = $NbInscriptionsMax;

        return $this;
    }

    public function getInfosEvent(): ?string
    {
        return $this->infosEvent;
    }

    public function setInfosEvent(string $infosEvent): static
    {
        $this->infosEvent = $infosEvent;

        return $this;
    }

    public function getReasonCancellation(): ?string
    {
        return $this->ReasonCancellation;
    }

    public function setReasonCancellation(?string $ReasonCancellation): static
    {
        $this->ReasonCancellation = $ReasonCancellation;

        return $this;
    }

    public function getSchoolsite(): ?Campus
    {
        return $this->schoolsite;
    }

    public function setSchoolsite(?Campus $schoolsite): static
    {
        $this->schoolsite = $schoolsite;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUserregistred(): Collection
    {
        return $this->userregistred;
    }

    public function addUserregistred(User $userregistred): static
    {
        if (!$this->userregistred->contains($userregistred)) {
            $this->userregistred->add($userregistred);
        }

        return $this;
    }

    public function removeUserregistred(User $userregistred): static
    {
        $this->userregistred->removeElement($userregistred);

        return $this;
    }

    public function getLocationevent(): ?Location
    {
        return $this->locationevent;
    }

    public function setLocationevent(?Location $locationevent): static
    {
        $this->locationevent = $locationevent;

        return $this;
    }

    public function getEventstate(): ?State
    {
        return $this->eventstate;
    }

    public function setEventstate(?State $eventstate): static
    {
        $this->eventstate = $eventstate;

        return $this;
    }

    public function getEventorgenazedby(): ?User
    {
        return $this->eventorgenazedby;
    }

    public function setEventorgenazedby(?User $eventorgenazedby): static
    {
        $this->eventorgenazedby = $eventorgenazedby;

        return $this;
    }
//
//    public function __toString()
//    {
//        $elements = $this->collection->toArray(); // Supposons que $this->collection est votre PersistentCollection
//        $strings = array_map(function ($element) {
//            return (string)$element->getId(); // Supposons que vous voulez obtenir l'ID de chaque élément
//        }, $elements);
//
//        return implode(', ', $strings); // Construisez une chaîne en séparant les éléments par des virgules (ou tout autre séparateur souhaité)
//    }




    public function isEventFull(): bool
    {
        if ($this->getNbInscriptionsMax() && $this->getUserregistred()->count() >= $this->getNbInscriptionsMax()){
            return true;
        }

       return false;
    }
}