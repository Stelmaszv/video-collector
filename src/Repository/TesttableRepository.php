<?php

namespace App\Repository;

use App\Entity\Testtable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Testtable|null find($id, $lockMode = null, $lockVersion = null)
 * @method Testtable|null findOneBy(array $criteria, array $orderBy = null)
 * @method Testtable[]    findAll()
 * @method Testtable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TesttableRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Testtable::class);
    }

    // /**
    //  * @return Testtable[] Returns an array of Testtable objects
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
    public function findOneBySomeField($value): ?Testtable
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
