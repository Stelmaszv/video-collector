<?php

namespace App\Repository;

use App\Entity\Nproducent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Nproducent|null find($id, $lockMode = null, $lockVersion = null)
 * @method Nproducent|null findOneBy(array $criteria, array $orderBy = null)
 * @method Nproducent[]    findAll()
 * @method Nproducent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NproducentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Nproducent::class);
    }

    // /**
    //  * @return Nproducent[] Returns an array of Nproducent objects
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
    public function findOneBySomeField($value): ?Nproducent
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
