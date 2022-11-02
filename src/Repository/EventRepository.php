<?php

namespace App\Repository;

use App\Entity\Event;
use App\Entity\User;
use App\Form\Model\SearchData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
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

    public function save(Event $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Event $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    /**
     * Récupère les events en lien avec une recherche
     *
     */



    public function findEvents(SearchData $search, User $user): Paginator
    {

        $qb = $this ->createQueryBuilder('events');

        if (!empty($search->search)) {
            $qb ->andWhere('events.name LIKE :q')
                ->setParameter('q',"%{$search->search}%");
        }

//        if (!empty($search->Campus)) {
//            $qb
//                ->andWhere('events.campus = campus')
//                ->setParameter('campus', "%{$search->campus}%");
//        }
//
//
        if ($search->isOrganizer = true) {
            $qb->andWhere('events.organizater = :user')
                ->setParameter('user', $user);
        }
//
//        if (!empty($search->promo)) {
//            $qb = $qb
//                ->andWhere('p.promo = 1');
//        }
//
//        if (!empty($search->categories)) {
//            $qb = $qb
//                ->andWhere('c.id IN (:categories)')
//                ->setParameter('categories', $search->categories);
//        }

        $query = $qb->getQuery();
        $query->setMaxResults(20);

        return new Paginator($query);

    }



}
