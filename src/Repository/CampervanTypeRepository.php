<?php

namespace App\Repository;

use App\Entity\CampervanType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CampervanType>
 *
 * @method CampervanType|null find($id, $lockMode = null, $lockVersion = null)
 * @method CampervanType|null findOneBy(array $criteria, array $orderBy = null)
 * @method CampervanType[]    findAll()
 * @method CampervanType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CampervanTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CampervanType::class);
    }

    public function add(CampervanType $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CampervanType $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
