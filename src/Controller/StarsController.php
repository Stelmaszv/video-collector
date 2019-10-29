<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\StarsRepository;
use App\Services\CRUD;
use App\Entity\Stars;
use App\Form\StarsType;

class StarsController extends AbstractController
{   
    /**
     * @Route("/faindStars/{searchvalue}", name="faindStars")
    */
    public function faindStars(StarsRepository $StarsRepository,CRUD $CRUD,Request $Request){
        $settings=[
            'function'=>'searchinRepository',
            'functionarguments'=>[
                'searchvalue'=>$Request->get('searchvalue'),
            ],
            'templete'=>'navigation/itemlist.html.twig',
            'photoField'=>'avatar',
            'uplodUrl'=> 'series_directory',
            'twing' => [
                'photourl'    =>'stars',
                'title'       =>'Edit Series',
                'sectionName' =>'Stars',
                'editLink'    =>'editStars',
                'deleteLink'  =>'deleteStar',
                'url'         =>'show_movies_with_star',
            ]
        ];
        
        return $CRUD->reed($StarsRepository,$settings);
    }
    /**
     * @Route("/showStars", name="showStars")
    */
    
    public function showStars(StarsRepository $StarsRepository,CRUD $CRUD){
        $settings=[
            'function'    =>'findAll',
            'templete'=>'navigation/itemlist.html.twig',
            'photoField'=>'avatar',
            'uplodUrl'=> 'series_directory',
            'twing' => [
                'photourl'    =>'stars',
                'title'       =>'Edit Series',
                'sectionName' =>'Stars',
                'editLink'    =>'editStars',
                'deleteLink'  =>'deleteStar',
                'url'         =>'show_movies_with_star',
            ]
        ];
        
        return $CRUD->reed($StarsRepository,$settings);
    }
    /**
     * @Route("/show_movies_with_star/{id}", name="show_movies_with_star")
     */
    public function show_movies_with_star(Request $Request,StarsRepository $StarsRepository,CRUD $CRUD){
        $array=[
            'function'=>'getCollectionInEntity',
            'functionarguments'=>[
                'getName'=>'Movies',
            ],
            'id'=> $Request->get('id'),
            'templete'=>'navigation/showmovies.htm.twig',
            'photourl'=>'',
            'url'     =>'show_movie',
            'sectionName' =>'Star dqd',
            'editLink'=>'editProducent',
            'deleteLink'=>'deleteMovie',
            'twing' => [
                'title'=>'Edit Series',
                'sectionName' =>'Show Movie with Star',
                'editLink'    =>'editStars',
                'deleteLink'  =>'deleteMovie',
                'url'         =>'show_movie',
            ]
            
        ];
        return $CRUD->reed($StarsRepository,$array);
    }
    /**
    * @Route("/editStars/{id}", name="editStars")
    */
    public function editStars(Request $request, $id,CRUD $CRUD){
        $settings=[
            'templete'=>'createitems/create.html.twig',
            'photoField'=>'avatar',
            'uplodUrl'=> 'stars_directory',
            'twing' => [
                'title'=>'Edit Stars'
            ]
        ];
        return $CRUD->updata(StarsType::class,Stars::class,$request,$id,$settings);
    }
    /**
     * @Route("/deleteStar/{id}", name="deleteStar")
     */
    public function deleteStar($id,CRUD $CRUD){
        return $CRUD->delete($id,Stars::class,'showStars');
      }
    /**
     * @Route("/createStars", name="createStars")
     */
    public function createStars(Request $Request,CRUD $CRUD){
        $settings=[
            'templete'=>'createitems/create.html.twig',
            'photoField'=>'avatar',
            'uplodUrl'=> 'producent_directory',
            'twing' => [
                'title'=>'Create Star'
            ],
            'header'=>'showStars'
        ];
        return $CRUD->create(StarsType::class, new Stars(),$Request,$settings);
    }
}
