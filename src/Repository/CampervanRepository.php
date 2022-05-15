<?php

namespace App\Repository;

use App\Entity\Campervan;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Campervan>
 *
 * @method Campervan|null find($id, $lockMode = null, $lockVersion = null)
 * @method Campervan|null findOneBy(array $criteria, array $orderBy = null)
 * @method Campervan[]    findAll()
 * @method Campervan[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CampervanRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Campervan::class);
    }

    public function add(Campervan $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Campervan $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
