<?php

namespace App\Repository;

use App\Entity\Cantry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Cantry|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cantry|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cantry[]    findAll()
 * @method Cantry[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CantryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cantry::class);
    }

    // /**
    //  * @return Cantry[] Returns an array of Cantry objects
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
    public function findOneBySomeField($value): ?Cantry
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
