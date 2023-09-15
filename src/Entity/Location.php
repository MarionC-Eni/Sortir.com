<?php

namespace App\Entity;

use App\Repository\LocationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LocationRepository::class)]
class Location
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $idLocation = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $street = null;

    #[ORM\Column(nullable: true)]
    private ?float $latitude = null;

    #[ORM\Column(nullable: true)]
    private ?float $longitude = null;

    #[ORM\ManyToOne(inversedBy: 'locations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?City $city = null;

    #[ORM\OneToMany(mappedBy: 'locationevent', targetEntity: Event::class)]
    private Collection $eventslocation;

    public function __construct()
    {
        $this->eventslocation = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdLocation(): ?int
    {
        return $this->idLocation;
    }

    public function setIdLocation(int $idLocation): static
    {
        $this->idLocation = $idLocation;

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

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): static
    {
        $this->street = $street;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(?float $latitude): static
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(?float $longitude): static
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getCity(): ?city
    {
        return $this->city;
    }

    public function setCity(?city $city): static
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return Collection<int, Event>
     */
    public function getEventslocation(): Collection
    {
        return $this->eventslocation;
    }

    public function addEventslocation(Event $eventslocation): static
    {
        if (!$this->eventslocation->contains($eventslocation)) {
            $this->eventslocation->add($eventslocation);
            $eventslocation->setLocationevent($this);
        }

        return $this;
    }

    public function removeEventslocation(Event $eventslocation): static
    {
        if ($this->eventslocation->removeElement($eventslocation)) {
            // set the owning side to null (unless already changed)
            if ($eventslocation->getLocationevent() === $this) {
                $eventslocation->setLocationevent(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return (string) $this->id;
    }

}
