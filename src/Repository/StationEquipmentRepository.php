<?php

namespace App\Repository;

use App\Entity\StationEquipment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<StationEquipment>
 *
 * @method StationEquipment|null find($id, $lockMode = null, $lockVersion = null)
 * @method StationEquipment|null findOneBy(array $criteria, array $orderBy = null)
 * @method StationEquipment[]    findAll()
 * @method StationEquipment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StationEquipmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StationEquipment::class);
    }

    public function add(StationEquipment $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(StationEquipment $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
