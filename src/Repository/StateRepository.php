<?php

namespace App\Repository;

use App\Entity\State;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<State>
 *
 * @method State|null find($id, $lockMode = null, $lockVersion = null)
 * @method State|null findOneBy(array $criteria, array $orderBy = null)
 * @method State[]    findAll()
 * @method State[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, State::class);

    }

    // Cette méthode findByLabel permet de rechercher un état par son libellé
    // le pb c'est qu'on a créé notre relation event-state via l'id et non par le label : je passe donc ce code en commentaire
//    public function findByLabel($label)
//    {
//
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.label = :label')
//            ->setParameter('label', $label)
//            ->getQuery()
//            ->getOneOrNullResult();
//    }

    // Cette méthode findByLabel permet de rechercher un état par son ID (le pb est qu'il faut retenir à quel label correspond chaque id)
    public function findById(int $id): ?State
    {
        return $this->findOneBy(['id' => $id]);
    }

}
// MC: voici le constructeur de base
//    public function __construct(ManagerRegistry $registry)
//    {
//        parent::__construct($registry, State::class);
//    }
//}

//    private $stateRepository;
//    private $entityManager;
//
//    public function __construct(StateRepository $stateRepository, EntityManagerInterface $entityManager)
//    {
//        $this->stateRepository = $stateRepository;
//        $this->entityManager = $entityManager;
//    }
//
//
//    public function Open()
//    {
//
//
////        $qb = $this->createQueryBuilder('o')
////
////    $openState = $stateRepo->findOneBy(['name' => 'open']);
////
////    $query = $qb->getQuery();
////
////    return $qb->getQuery()->getResult();
//
//        $states = array('created', 'open');
//        return $this
//            ->createQueryBuilder('s')
//            ->andWhere('s.label IN (:states)')
//            ->setParameter(':states', $states)
//            ->getQuery()->getResult();
//
//
//    }
//}


//    /**
//     * @return State[] Returns an array of State objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?State
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

