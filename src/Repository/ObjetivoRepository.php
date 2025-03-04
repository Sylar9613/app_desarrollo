<?php

namespace App\Repository;

use App\Entity\Objetivo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Objetivo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Objetivo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Objetivo[]    findAll()
 * @method Objetivo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ObjetivoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Objetivo::class);
    }

    // /**
    //  * @return Objetivo[] Returns an array of Objetivo objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Objetivo
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
