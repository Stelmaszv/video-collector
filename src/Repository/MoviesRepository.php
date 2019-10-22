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
    public function getMoviesWithStars(object $item,array $stars,int $id){
        $items=[];
        foreach($this->findAll() as $el){
            if($el->getId()!=$id){
                foreach($el->getStars() as $star){
                    if($this->faindStarInArray($star->getName(),$stars)){
                        array_push($items,$el);
                    }
                }
            }
        }
        return $items;
    }
    public function getMoviesWithTags(object $item,array $stars,int $id){
        $items=[];
        foreach($this->findAll() as $el){
            if($el->getId()!=$id){
                foreach($el->getTags() as $star){
                    if($this->faindStarInArray($star->getName(),$stars)){
                        array_push($items,$el);
                    }
                }
            }
        }
        return $items;

    }
    private function faindStarInArray(string $name,array $stars){
        foreach($stars as $star){
            if($name === $star->getName()){
                return true;
            }
        }
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
