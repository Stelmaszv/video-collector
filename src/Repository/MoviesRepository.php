<?php

namespace App\Repository;

use App\Entity\Movies;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use App\Repository\abstractRepository;

/**
 * @method Movies|null find($id, $lockMode = null, $lockVersion = null)
 * @method Movies|null findOneBy(array $criteria, array $orderBy = null)
 * @method Movies[]    findAll()
 * @method Movies[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MoviesRepository extends abstractRepository
{
    public function __construct(ManagerRegistry $registry){
        parent::__construct($registry, Movies::class);
    }
    public function getMoviesInSeries(Object $item,int $id){
        $items=[];
        foreach($this->findAll() as $el){
            if($el->getId()!=$id){
                if($el->getSeries()==$item->getSeries()){
                    array_push($items,$el);
                }
            }
        }
        return $items;
    }
    public function Orderby(){
        $qb= $this->createQueryBuilder('m')
        ->orderBy('m.views', 'DESC');
        $query = $qb->getQuery();
        return $query->execute();

    }
    public function getMoviesWithStars(object $item,array $stars,int $id){
        return $this->faindArrayInRepository($item,$stars,$id,'getStars');
    }
    public function getMoviesWithTags(object $item,array $tags,int $id){
        return $this->faindArrayInRepository($item,$tags,$id,'getTags');
    }   
    public function updateViews(object $item,object $em){
        $views=$item->getViews();
        $item->setViews($views+1);
        $em->persist($item);
        $em->flush();

    }
    // /**
    //  * @return Movies[] Returns an array of Movies objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Movies
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
