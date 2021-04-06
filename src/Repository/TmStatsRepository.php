<?php

namespace App\Repository;

use App\Entity\TmStats;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TmStats|null find($id, $lockMode = null, $lockVersion = null)
 * @method TmStats|null findOneBy(array $criteria, array $orderBy = null)
 * @method TmStats[]    findAll()
 * @method TmStats[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TmStatsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TmStats::class);
    }

    // /**
    //  * @return TmStats[] Returns an array of TmStats objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TmStats
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
