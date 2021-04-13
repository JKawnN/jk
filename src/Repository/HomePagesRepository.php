<?php

namespace App\Repository;

use App\Entity\HomePages;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method HomePages|null find($id, $lockMode = null, $lockVersion = null)
 * @method HomePages|null findOneBy(array $criteria, array $orderBy = null)
 * @method HomePages[]    findAll()
 * @method HomePages[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HomePagesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HomePages::class);
    }

    /**
    * @return Map[] Returns an array of Map objects
    */
    public function findAllDescById()
    {
        return $this->createQueryBuilder('h')
            ->orderBy('h.homeOrder', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?HomePages
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
