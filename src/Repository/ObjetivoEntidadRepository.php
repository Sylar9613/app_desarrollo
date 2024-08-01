<?php

namespace App\Repository;

use App\Entity\ObjetivoEntidad;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ObjetivoEntidad|null find($id, $lockMode = null, $lockVersion = null)
 * @method ObjetivoEntidad|null findOneBy(array $criteria, array $orderBy = null)
 * @method ObjetivoEntidad[]    findAll()
 * @method ObjetivoEntidad[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ObjetivoEntidadRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ObjetivoEntidad::class);
    }

    // /**
    //  * @return ObjetivoEntidad[] Returns an array of ObjetivoEntidad objects
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
    public function findOneBySomeField($value): ?ObjetivoEntidad
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
