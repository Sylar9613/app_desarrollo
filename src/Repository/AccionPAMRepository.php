<?php

namespace App\Repository;

use App\Entity\AccionPAM;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method AccionPAM|null find($id, $lockMode = null, $lockVersion = null)
 * @method AccionPAM|null findOneBy(array $criteria, array $orderBy = null)
 * @method AccionPAM[]    findAll()
 * @method AccionPAM[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AccionPAMRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AccionPAM::class);
    }

    // /**
    //  * @return Accion[] Returns an array of Accion objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Accion
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
