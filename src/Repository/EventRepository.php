<?php

namespace App\Repository;

use App\Entity\Event;
use App\Entity\User;
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

    public function findEvents(SearchData $search): Paginator
    {

        $qb = $this ->createQueryBuilder('events');

        if (!empty($search->search)) {
            $qb ->andWhere('events.name LIKE :q')
                ->setParameter('q',"%{$search->search}%");
        }

        if (!empty($search->campus)) {
            $qb->andWhere('events.campus = :c')
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
            $qb->andWhere('events.organizater = :user')
                ->setParameter('user', $this->security->getUser());
        }

        if ($search->isBooked) {

            $qb->andWhere(':user MEMBER OF events.goers')
                ->setParameter('user', $this->security->getUser());
        }

        if ($search->isNotBooked) {
            $qb->andWhere(':user NOT MEMBER OF events.goers')
                ->setParameter('user', $this->security->getUser());
        }

        if ($search->passedEvents) {
            $qb->addSelect('state')
                ->leftJoin('events.state', 'state')
                ->andWhere('state.libelle = :passed')
                ->setParameter('passed', 'passed');
        }

        $query = $qb->getQuery();
        $query->setMaxResults(20);

        return new Paginator($query);

    }

    public function findGoers(Event $event,){
        $qb = $this->createQueryBuilder('event');

        $qb->addSelect('goers')
            ->leftJoin('event.goers', 'goers')
            ->andWhere('event.id = :id')
            ->setParameter('id', $event->getId())
            ;

        $query = $qb->getQuery();

        return $query->getResult();
    }

}
