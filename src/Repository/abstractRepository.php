<?php

namespace App\Repository;

use App\Entity\Movies;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Movies|null find($id, $lockMode = null, $lockVersion = null)
 * @method Movies|null findOneBy(array $criteria, array $orderBy = null)
 * @method Movies[]    findAll()
 * @method Movies[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
abstract class abstractRepository extends ServiceEntityRepository{
    public function getCollectionInEntity(array $function){
        $items=[];
        $item=$function['item'];
        $function='get'.$function['getName'];
        foreach ($item->$function() as $el){
            array_push($items,$el);
        }
        return $items;
    }
    public function searchinRepository($arguments=false){
        $qb = $this->createQueryBuilder('u');
        $qb->where(
                 $qb->expr()->like('u.name', ':user')
             )
             ->setParameter('user','%'.$arguments['searchvalue'].'%');
        return $query=$qb->getQuery()->getResult();
   
    }
    protected function faindArrayInRepository(object $item,array $tags,int $id,string $function){
        $items=[];
        foreach($this->findAll() as $el){
            if($el->getId()!=$id){
                foreach($el->$function() as $star){
                    if($this->faindItemInArray($star->getName(),$tags)){
                        array_push($items,$el);
                    }
                }
            }
        }
        return $items;
    } 
    private function faindItemInArray(string $name,array $stars){
        foreach($stars as $star){
            if($name === $star->getName()){
                return true;
            }
        }
    }
}