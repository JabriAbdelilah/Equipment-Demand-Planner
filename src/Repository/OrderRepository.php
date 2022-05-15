<?php

namespace App\Repository;

use App\Entity\Order;
use DateInterval;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Order>
 *
 * @method Order|null find($id, $lockMode = null, $lockVersion = null)
 * @method Order|null findOneBy(array $criteria, array $orderBy = null)
 * @method Order[]    findAll()
 * @method Order[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    public function add(Order $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Order $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByReturnStationAndDateInterval(int $stationId, DateTime $startDay, DateTime $endDay): array
    {
        $date = clone($startDay);
        $date->setTime(0, 0);
        $datePlusDay = clone($endDay);
        $datePlusDay->setTime(23, 59);

        return $this->createQueryBuilder('o')
            ->andWhere('o.returnStation = :stationId')
            ->andWhere('o.status IN (:status)')
            ->andWhere('o.endDate > :date')
            ->andWhere('o.endDate < :datePlusDay')
            ->setParameter('stationId', $stationId)
            ->setParameter('status', [Order::STATUS['CONFIRMED'], Order::STATUS['IN_PROGRESS']])
            ->setParameter('date', $date)
            ->setParameter('datePlusDay', $datePlusDay)
            ->getQuery()
            ->getResult();
    }

    public function findByPickupStationAndDate(int $stationId, DateTime $day): array
    {
        $date = clone($day);
        $date->setTime(0, 0);
        $datePlusDay = clone($date);
        $datePlusDay->add(new DateInterval('P1D'));

        return $this->createQueryBuilder('o')
            ->andWhere('o.pickupStation = :stationId')
            ->andWhere('o.status = :status')
            ->andWhere('o.startDate > :date')
            ->andWhere('o.startDate < :datePlusDay')
            ->setParameter('stationId', $stationId)
            ->setParameter('status', Order::STATUS['CONFIRMED'])
            ->setParameter('date', $date)
            ->setParameter('datePlusDay', $datePlusDay)
            ->getQuery()
            ->getResult();
    }

    public function findByPickupStationAndDateInterval(int $stationId, DateTime $startDay, DateTime $endDay): array
    {
        $date = $startDay;
        $date->setTime(0, 0);
        $datePlusDay = clone($endDay);
        $datePlusDay->sub(new DateInterval('P1D'));
        $datePlusDay->setTime(23, 59);

        return $this->createQueryBuilder('o')
            ->andWhere('o.pickupStation = :stationId')
            ->andWhere('o.status in (:status)')
            ->andWhere('o.startDate > :date')
            ->andWhere('o.startDate < :datePlusDay')
            ->setParameter('stationId', $stationId)
            ->setParameter('status', [Order::STATUS['CONFIRMED'], Order::STATUS['IN_PROGRESS'], Order::STATUS['DONE']])
            ->setParameter('date', $date)
            ->setParameter('datePlusDay', $datePlusDay)
            ->getQuery()
            ->getResult();
    }
}
