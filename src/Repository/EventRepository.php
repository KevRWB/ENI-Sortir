<?php

namespace App\Repository;

use App\Entity\Event;
use App\Form\Model\SearchData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;

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

    public function __construct(ManagerRegistry $registry, private Security $security)
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

    public function findEvents(SearchData $search)
    {

        $user = $this->security->getUser();

        $qb = $this ->createQueryBuilder('events');

        $qb->addSelect('goers')
            ->leftJoin('events.goers', 'goers')
            ->addSelect('state')
            ->leftJoin('events.state', 'state')
            ->addSelect('campus')
            ->leftJoin('events.campus', 'campus')
            ->addSelect('organizater')
            ->leftJoin('events.organizater', 'organizater');

        if (!empty($search->search)) {
            $qb ->andWhere('events.name LIKE :q')
                ->setParameter('q',"%{$search->search}%");
        }

        if (!empty($search->campus)) {
            $qb
                ->andWhere('campus = :c')
                ->setParameter('c', $search->campus);
        }

        if (!empty($search->startDate) && !empty($search->endDate) ) {
            $qb->andWhere('events.startDate BETWEEN :start AND :end')
                ->setParameter('start', $search->startDate)
                ->setParameter('end', $search->endDate);
        }elseif(!empty($search->startDate)){
            $qb->andWhere('events.startDate > :start')
                ->setParameter('start', $search->startDate);
        }elseif (!empty($search->endDate)){
            $qb->andWhere('events.startDate < :end')
                ->setParameter('end', $search->endDate);
        }

        if ($search->isOrganizer) {
            $qb
                ->andWhere('organizater = :user')
                ->setParameter('user', $user);
        }

        if ($search->isBooked) {
            $qb
                ->andWhere(':user MEMBER OF goers')
                ->setParameter('user', $user);
        }

        if ($search->isNotBooked) {

            $qb
                ->andWhere(':user MEMBER OF goers')
                ->andWhere(':user NOT MEMBER OF goers')
                ->setParameter('user', $user);
        }

        if ($search->passedEvents) {
            $qb->andWhere('state.libelle = :passed')
                ->setParameter('passed', 'passed');
        }

        $qb->setFirstResult(0);
//        $qb->setMaxResults(10);

        $query = $qb->getQuery();

        return $query->getResult();
//        return new Paginator($query, true);

    }

//    public function findAllEventsWithLocation(): Paginator{
//        $qb = $this ->createQueryBuilder('events');
//
//        $qb->addSelect('location')
//            ->leftJoin('events.location', 'location');
//
//        $query = $qb->getQuery()->setMaxResults(10);
//
//        return new Paginator($query);
//    }

    public function findAllEventsWithGoersAndState(){
        $qb = $this ->createQueryBuilder('events');

        $qb->addSelect('goers')
            ->leftJoin('events.goers', 'goers')
            ->addSelect('state')
            ->leftJoin('events.state', 'state');


        return $qb->getQuery()->getResult();

    }

}
