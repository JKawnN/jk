<?php

namespace App\Repository;

use App\Entity\CapitalPantheraTrade;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CapitalPantheraTrade|null find($id, $lockMode = null, $lockVersion = null)
 * @method CapitalPantheraTrade|null findOneBy(array $criteria, array $orderBy = null)
 * @method CapitalPantheraTrade[]    findAll()
 * @method CapitalPantheraTrade[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CapitalPantheraTradeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CapitalPantheraTrade::class);
    }

    // /**
    //  * @return CapitalPantheraTrade[] Returns an array of CapitalPantheraTrade objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CapitalPantheraTrade
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
