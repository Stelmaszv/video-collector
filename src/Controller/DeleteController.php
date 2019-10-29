<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Services\CRUD;
use App\Entity\Movies;
use App\Entity\Series;
use App\Entity\Producent;
use App\Entity\Tags;
use App\Entity\Stars;
class DeleteController extends AbstractController
{
    /**
     * @Route("/deleteProducents/{id}", name="deleteProducents")
     */
    public function deleteProducents($id,CRUD $CRUD){
      return $CRUD->delete($id,Producent::class,'showProducents');
    }
    /**
     * @Route("/deleteMovie/{id}", name="deleteMovie")
     */
    public function deleteMovie($id,CRUD $CRUD){
      return $CRUD->delete($id,Movies::class,'main');
    }
    /**
     * @Route("/deleteSeries/{id}", name="deleteSeries")
     */
    public function deleteSeries($id,CRUD $CRUD){
      return $CRUD->delete($id,Series::class,'showSeries');
    }
        /**
     * @Route("/deleteTag/{id}", name="deleteTag")
     */
    public function deleteTag($id,CRUD $CRUD){
      return $CRUD->delete($id,Tags::class,'showCategory');
    }
            /**
     * @Route("/deleteStar/{id}", name="deleteStar")
     */
    public function deleteStar($id,CRUD $CRUD){
      return $CRUD->delete($id,Stars::class,'showStars');
    }
}
