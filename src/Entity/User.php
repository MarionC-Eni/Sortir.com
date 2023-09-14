<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
//use Symfony\Component\Validator\Constraints as Assert


#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
#[UniqueEntity(fields: ['pseudo'], message: 'There is already an account with this pseudo')]
class User implements UserInterface, \Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    // MC: ajout de generatedValue
    // MC: en fait cette proriété est un doublon de id. DONC supprimer cette colonne de la BDD
   //  #[ORM\Column]
    // #[ORM\GeneratedValue(strategy: 'AUTO', nullable: true)] // Ou 'AUTO', 'IDENTITY', etc., selon la stratégie de génération appropriée
    #[ORM\Column(nullable: true)]
    private ?int $idUser = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $username = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $firstname = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $phone = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(type: Types::BOOLEAN, nullable: true)]
    private ?bool $isAdmin = null;

    #[ORM\Column(type: Types::BOOLEAN, nullable: true)]
    private ?bool $isRegisteredToEvent = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $pseudo = null;

    #[ORM\Column(type: Types::BLOB, nullable: true)]
    private $photo = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Campus $Mycampus = null;
    //private $userIdentifier;

    #[ORM\Column(type:"json")]
    private array $roles = [];

    #[ORM\ManyToMany(targetEntity: Event::class, mappedBy: 'userregistred')]
    private Collection $registredevents;

    #[ORM\OneToMany(mappedBy: 'eventorgenazedby', targetEntity: Event::class)]
    private Collection $organizedby;

    public function __construct()
    {
        $this->registredevents = new ArrayCollection();
        $this->organizedby = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUser(): ?int
    {
        return $this->idUser;
    }

    public function setIdUser(int $idUser): static
    {
        $this->idUser = $idUser;

        return $this;
    }

    // je change le nom de ma propriété name
    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

//    public function getName(): ?string
//    {
//        return $this->name;
//    }
//
//    public function setName(string $name): static
//    {
//        $this->name = $name;
//
//        return $this;
//    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function isIsAdmin(): ?bool
    {
        return $this->isAdmin;
    }

    public function setIsAdmin(bool $isAdmin): static
    {
        $this->isAdmin = $isAdmin;

        return $this;
    }

    public function isIsRegisteredToEvent(): ?bool
    {
        return $this->isRegisteredToEvent;
    }

    public function setIsRegisteredToEvent(bool $isRegisteredToEvent): static
    {
        $this->isRegisteredToEvent = $isRegisteredToEvent;

        return $this;
    }

    public function getIsRegisteredToEvent(): ?bool
    {
        return $this->isRegisteredToEvent;
    }



    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): static
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getPhoto()
    {
        return $this->photo;
    }

    public function setPhoto($photo): static
    {
        $this->photo = $photo;

        return $this;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }


    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getUserIdentifier(): string
    {
        //    return $this->userIdentifier;
        return (string) $this->email;

    }

    public function getMycampus(): ?Campus
    {
        return $this->Mycampus;
    }

    public function setMycampus(?Campus $mycampus): static
    {
        $this->Mycampus = $mycampus;

        return $this;
    }

    /**
     * @return Collection<int, Event>
     */
    public function getRegistredevents(): Collection
    {
        return $this->registredevents;
    }

    public function addRegistredevent(Event $registredevent): static
    {
        if (!$this->registredevents->contains($registredevent)) {
            $this->registredevents->add($registredevent);
            $registredevent->addUserregistred($this);
        }

        return $this;
    }

    public function removeRegistredevent(Event $registredevent): static
    {
        if ($this->registredevents->removeElement($registredevent)) {
            $registredevent->removeUserregistred($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Event>
     */
    public function getOrganizedby(): Collection
    {
        return $this->organizedby;
    }

    public function addOrganizedby(Event $organizedby): static
    {
        if (!$this->organizedby->contains($organizedby)) {
            $this->organizedby->add($organizedby);
            $organizedby->setEventorgenazedby($this);
        }

        return $this;
    }

    public function removeOrganizedby(Event $organizedby): static
    {
        if ($this->organizedby->removeElement($organizedby)) {
            // set the owning side to null (unless already changed)
            if ($organizedby->getEventorgenazedby() === $this) {
                $organizedby->setEventorgenazedby(null);
            }
        }

        return $this;
    }

}
