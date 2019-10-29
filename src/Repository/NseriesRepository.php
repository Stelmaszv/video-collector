<?php

namespace App\Repository;

use App\Entity\Nseries;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Nseries|null find($id, $lockMode = null, $lockVersion = null)
 * @method Nseries|null findOneBy(array $criteria, array $orderBy = null)
 * @method Nseries[]    findAll()
 * @method Nseries[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NseriesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Nseries::class);
    }

    // /**
    //  * @return Nseries[] Returns an array of Nseries objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Nseries
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
