<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $idEvent = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATETIMETZ_MUTABLE)]
    private ?\DateTimeInterface $dateHourStart = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $duration = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateLimitInscription = null;

    #[ORM\Column]
    private ?int $NbInscriptionsMax = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $infosEvent = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $ReasonCancellation = null;

    #[ORM\ManyToOne(inversedBy: 'events')]
    private ?Campus $schoolsite = null;

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
}
