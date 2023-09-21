<?php

namespace App\Repository;

use App\Entity\Event;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Event>
 *
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    // requête Doctine avec des conditions de filtres pour les événements
    public function findByCriteria(array $criteria = [], User $user = null): array
    {
        $qb = $this->createQueryBuilder('e')
            ->orderBy('e.dateHourStart', 'ASC');

        if (isset($criteria['min_date'])) {
            $qb->andWhere('e.dateHourStart >= :min_date')
                ->setParameter('min_date', $criteria['min_date']);
        }

        if (isset($criteria['max_date'])) {
            $qb->andWhere('e.dateHourStart <= :max_date')
                ->setParameter('max_date', $criteria['max_date']);
        }

        if (isset($criteria['schoolsite'])) {
            $qb->andWhere('e.schoolsite = :schoolsite')
                ->setParameter('schoolsite', $criteria['schoolsite']);
        }

        //inclure les sorties dont je suis l'organisateur
//        if (!empty($criteria['eventorgenazedby']) && $user instanceof User) {
//            $qb->andWhere('e.eventorgenazedby = :organizer')
//                ->setParameter('organizer', $user->getId());
//        }

        //MC: tentative 2
//        if (!empty($criteria['eventorgenazedby']) && $criteria['eventorgenazedby'] === true) {
//            $qb->andWhere('e.eventorgenazedby IS NOT NULL');
//        }

        // tentative  3
//        if (isset($criteria['filtreOption'])) {
//            if ($criteria['filtreOption']) {
//                // Si la case à cocher est cochée, ajoutez ici la logique du filtre
//                $qb
//                    ->andWhere('e.eventorgenazedby = :user')
//                    ->setParameter('user', $criteria['eventorgenazedby']); // Remplacez 'utilisateur' par le nom du champ dans le formulaire
//            }
//        }

// tenative 4 qui fonctionne :
//        if ($user instanceof User) {
//            $qb->andWhere('e.eventorgenazedby = :organizer')
//                ->setParameter('organizer', $user);
//        }

        if (isset($criteria['eventorgenazedby']) && $criteria['eventorgenazedby']) {
            $qb->andWhere('e.eventorgenazedby = :organizer')
                ->setParameter('organizer', $user);
        }

        if ($user instanceof User && isset($criteria['userregistred']) && $criteria['userregistred']) {
            $qb->andWhere(':user MEMBER OF e.userregistred')
                ->setParameter('user', $user);
        }


// MC: On va distinguer les querybuilder "filter" les qb "chexbox" pour le moment et les assembler dans la requête finale
// $qb->andWhere($checkBox);

        $count = count($qb->getQuery()->getResult());

        // MC: on ajoute cette ligne pour récupérer les résultats
        $query = $qb->getQuery();

        return $qb->getQuery()->getResult();
    }

}



//    /**
//     * @return Event[] Returns an array of Event objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Event
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
