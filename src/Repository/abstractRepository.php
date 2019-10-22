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
    public function getCollectionInEntity(object $item,$function){
        $items=[];
        $function='get'.$function;
        foreach ($item->$function() as $el){
            array_push($items,$el);
        }
        return $items;
    }
}