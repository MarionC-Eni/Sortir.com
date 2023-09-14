<?php

namespace App\Entity;

use App\Repository\StateRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StateRepository::class)]
class State
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $idState = null;

    #[ORM\Column(length: 100)]
    private ?string $label = null;

    #[ORM\OneToMany(mappedBy: 'eventstate', targetEntity: Event::class)]
    private Collection $statesevent;

    public function __construct()
    {
        $this->statesevent = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdState(): ?int
    {
        return $this->idState;
    }

    public function setIdState(int $idState): static
    {
        $this->idState = $idState;

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return Collection<int, Event>
     */
    public function getStatesevent(): Collection
    {
        return $this->statesevent;
    }

    public function addStatesevent(Event $statesevent): static
    {
        if (!$this->statesevent->contains($statesevent)) {
            $this->statesevent->add($statesevent);
            $statesevent->setEventstate($this);
        }

        return $this;
    }

    public function removeStatesevent(Event $statesevent): static
    {
        if ($this->statesevent->removeElement($statesevent)) {
            // set the owning side to null (unless already changed)
            if ($statesevent->getEventstate() === $this) {
                $statesevent->setEventstate(null);
            }
        }

        return $this;
    }
}
