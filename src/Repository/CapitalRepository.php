<?php

namespace App\Repository;

use App\Entity\capital;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method capital|null find($id, $lockMode = null, $lockVersion = null)
 * @method capital|null findOneBy(array $criteria, array $orderBy = null)
 * @method capital[]    findAll()
 * @method capital[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CapitalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, capital::class);
    }

    // /**
    //  * @return capital[] Returns an array of capital objects
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
    public function findOneBySomeField($value): ?capital
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
