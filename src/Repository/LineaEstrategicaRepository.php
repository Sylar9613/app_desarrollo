<?php

namespace App\Repository;

use App\Entity\LineaEstrategica;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method LineaEstrategica|null find($id, $lockMode = null, $lockVersion = null)
 * @method LineaEstrategica|null findOneBy(array $criteria, array $orderBy = null)
 * @method LineaEstrategica[]    findAll()
 * @method LineaEstrategica[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LineaEstrategicaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LineaEstrategica::class);
    }

     /**
      * @return LineaEstrategica[] Returns an array of LineaEstrategica objects
      */
    public function findAllLineas()
    {
        $em = $this->getEntityManager();
        $consulta2 = $em->getRepository('App\Entity\LineaEstrategica')->findAll();
        /**
         * @var Collection|LineaEstrategica[] $collection
         */
        $collection = new ArrayCollection();
        /**
         * @var LineaEstrategica $item
         */
        foreach ($consulta2 as $item)
        {
            if ($item->getActivo()==1){
                $collection->add($item);
            }
        }
        /*var_dump($collection);die;*/
        return $collection;
    }


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
