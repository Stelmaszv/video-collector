<?php

namespace App\Repository;

use App\Entity\NMovies;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method NMovies|null find($id, $lockMode = null, $lockVersion = null)
 * @method NMovies|null findOneBy(array $criteria, array $orderBy = null)
 * @method NMovies[]    findAll()
 * @method NMovies[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NMoviesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NMovies::class);
    }

    // /**
    //  * @return NMovies[] Returns an array of NMovies objects
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
    public function findOneBySomeField($value): ?NMovies
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
