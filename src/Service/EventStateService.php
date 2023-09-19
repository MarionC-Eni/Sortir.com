<?php

namespace App\Service\EventStateService;

use App\Entity\Event;
use App\Entity\State;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\Integer;
use App\Repository\StateRepository;
use Doctrine\ORM\EntityManagerInterface;

class EventStateService
{

    private $stateRepository;
    private $entityManager;

    public function __construct(StateRepository $stateRepository, EntityManagerInterface $entityManager)
    {
        $this->stateRepository = $stateRepository;
        $this->entityManager = $entityManager;
    }

//     Méthode pour obtenir un état par son ID mais à voir si on en a besoin
    public function getStateById(int $stateId): ?State
    {
        return $this->stateRepository->find($stateId);
    }

    // Méthode pour changer l'état de l'événement en utilisant l'ID de l'état
    public function changeEventState(Event $event, State $newState)
    {
// à voir si c'est nécessaire, si oui il faudra repasser int $newStateId en paramètre :
//        $newState = $this->getStateById($newStateId);
//        if ($newState) {
//            $event->setEventstate($newState);

        $event->setEventstate($newState);

        // Persister les changements dans la base de données
            $this->entityManager->persist($event);
            $this->entityManager->flush();
        }
}
    // tentative en passant par le label et non par l'id :
//    public function changeEventState(Event $event, string $newStateLabel)
//    {
//        $newState = $this->getStateByLabel($newStateLabel);
//        $event->setEventstate($newState);
//
//        // Persister les changements dans la base de données
//        $this->entityManager->persist($event);
//        $this->entityManager->flush();
//    }
