<?php

namespace App\Repository;

use App\Entity\Producent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use App\Repository\abstractRepository;

/**
 * @method Producent|null find($id, $lockMode = null, $lockVersion = null)
 * @method Producent|null findOneBy(array $criteria, array $orderBy = null)
 * @method Producent[]    findAll()
 * @method Producent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProducentRepository extends abstractRepository
{
    public function __construct(ManagerRegistry $registry){
        parent::__construct($registry, Producent::class);
    }
    public function list_of_series_in_producent(object $producents){
        $item=[];
        foreach ($producents->getSeries() as $el){
            array_push($item,$el);
        }
        return $item;
    }
    // /**
    //  * @return Producent[] Returns an array of Producent objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Producent
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
