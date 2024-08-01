<?php

namespace App\Repository;

use App\Entity\PAM;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method PAM|null find($id, $lockMode = null, $lockVersion = null)
 * @method PAM|null findOneBy(array $criteria, array $orderBy = null)
 * @method PAM[]    findAll()
 * @method PAM[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PAMRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PAM::class);
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
