<?php

namespace App\Entity;

use App\Repository\CampusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CampusRepository::class)]
class Campus
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $idCampus = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'campus', targetEntity: User::class, orphanRemoval: true)]
    private Collection $users;

    #[ORM\OneToMany(mappedBy: 'campus', targetEntity: Event::class)]
    private Collection $events;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->events = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdCampus(): ?int
    {
        return $this->idCampus;
    }

    public function setIdCampus(int $idCampus): static
    {
        $this->idCampus = $idCampus;

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

    /**
     * @return Collection<int, user>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(user $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setMycampus($this);
        }

        return $this;
    }

    public function removeUser(user $user): static
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getMycampus() === $this) {
                $user->setMycampus(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, event>
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(event $event): static
    {
        if (!$this->events->contains($event)) {
            $this->events->add($event);
            $event->setSchoolsite($this);
        }

        return $this;
    }

    public function removeEvent(event $event): static
    {
        if ($this->events->removeElement($event)) {
            // set the owning side to null (unless already changed)
            if ($event->getSchoolsite() === $this) {
                $event->setSchoolsite(null);
            }
        }

        return $this;
    }
}
