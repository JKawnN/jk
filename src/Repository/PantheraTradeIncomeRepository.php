<?php

namespace App\Repository;

use App\Entity\PantheraTradeIncome;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PantheraTradeIncome|null find($id, $lockMode = null, $lockVersion = null)
 * @method PantheraTradeIncome|null findOneBy(array $criteria, array $orderBy = null)
 * @method PantheraTradeIncome[]    findAll()
 * @method PantheraTradeIncome[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PantheraTradeIncomeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PantheraTradeIncome::class);
    }

    /**
    * @return PantheraTradeIncome[] Returns an array of PantheraTradeIncome objects oredered by date
    */

    public function findAllByDateAndUser($user)
    {
        return $this->createQueryBuilder('i')
            ->leftJoin('i.CapitalPantheraTrade', 'cp')
            ->addSelect('cp')
            ->andWhere('cp.User = :user')
            ->setParameter('user', $user)
            ->orderBy('i.date', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

     /**
    * @return PantheraTradeIncome[] Return last object from user
    */

    public function findLastDayIncome($user)
    {
        return $this->createQueryBuilder('i')
            ->leftJoin('i.CapitalPantheraTrade', 'cp')
            ->addSelect('cp')
            ->andWhere('cp.User = :user')
            ->setParameter('user', $user)
            ->orderBy('i.date', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?PantheraTrade
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
