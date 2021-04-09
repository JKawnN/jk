<?php

namespace App\Repository;

use App\Entity\Map;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Map|null find($id, $lockMode = null, $lockVersion = null)
 * @method Map|null findOneBy(array $criteria, array $orderBy = null)
 * @method Map[]    findAll()
 * @method Map[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MapRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Map::class);
    }

    /**
    * @return Map[] Returns an array of Map objects
    */
    public function findAllWithStats()
    {
        return $this->createQueryBuilder('m')
            ->leftJoin('m.category', 'c')
            ->addSelect('c')
            ->leftJoin('m.mapHasPlayerStats', 'ms')
            ->addSelect('ms')
            ->leftJoin('ms.player', 'p')
            ->addSelect('p')
            ->orderBy('m.id', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findAllWithStatsOrderedByName()
    {
        return $this->createQueryBuilder('m')
            ->leftJoin('m.category', 'c')
            ->addSelect('c')
            ->leftJoin('m.mapHasPlayerStats', 'ms')
            ->addSelect('ms')
            ->leftJoin('ms.player', 'p')
            ->addSelect('p')
            ->orderBy('m.name', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?Map
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
