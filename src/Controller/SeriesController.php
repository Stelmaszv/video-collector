<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\SeriesRepository;
use App\Entity\Series;
use App\Form\SeriesType;
use App\Services\CRUD;
class SeriesController extends AbstractController
{

         /**
     * @Route("/faindSeries/{searchvalue}", name="faindSeries")
     */
    public function faindSeries(SeriesRepository $SeriesRepository,CRUD $CRUD,request $request){
        $array=[
            'function'=>'searchinRepository',
            'functionarguments'=>[
                'searchvalue'=>$request->get('searchvalue'),
            ],
            'templete'=>'navigation/itemlist.html.twig',
            'twing' => [
                'photourl'=>'series',
                'title'=>'Edit Series',
                'sectionName' =>'Series',
                'editLink'    =>'editSeries',
                'deleteLink'  =>'deleteSeries',
                'url'         =>'show_movies_with_star',
            ]
        ];
        return $CRUD->reed($SeriesRepository,$array);
    }
       /**
     * @Route("/showSeries", name="showSeries")
     */
    public function showSeries(SeriesRepository $SeriesRepository,CRUD $CRUD){
        $array=[
            'function'=>'findAll',
            'templete'=>'navigation/itemlist.html.twig',
            'twing' => [
                'photourl'=>'series',
                'title'=>'Edit Series',
                'sectionName' =>'Series',
                'editLink'    =>'editSeries',
                'deleteLink'  =>'deleteSeries',
                'url'         =>'show_movies_with_star',
            ]
        ];
        
        return $CRUD->reed($SeriesRepository,$array);
    }
            /**
     * @Route("/show_movies_in_series/{id}", name="show_movies_in_series")
     */
    public function show_movies_in_series(Request $Request,SeriesRepository $SeriesRepository,CRUD $CRUD){
        $array=[
            'function'=>'getCollectionInEntity',
            'id'=> $Request->get('id'),
            'templete'=>'navigation/showmovies.htm.twig',
            'photourl'=>'series',
            'functionarguments'=>[
                'getName'=>'Movies',
            ],
            'url'     =>'show_movie',
            'sectionName' =>'Movies in series',
            'editLink'=>'editProducent',
            'deleteLink'=>'deleteMovie',
            'twing' => [
                'title'       =>'Edit Series',
                'sectionName' =>'series',
                'editLink'    =>'editStars',
                'deleteLink'  =>'deleteMovie',
                'url'         =>'show_movies_with_star',
            ]
        ];
        return $CRUD->reed($SeriesRepository,$array);
    }
    /**
    * @Route("/editSeries/{id}", name="editSeries")
    */
    public function editSeries(Request $request, $id,CRUD $CRUD){
        $settings=[
            'templete'=>'createitems/create.html.twig',
            'photoField'=>'avatar',
            'uplodUrl'=> 'series_directory',
            'twing' => [
                'title'=>'Edit Series'
            ]
        ];
        return $CRUD->updata(SeriesType::class,Series::class,$request,$id,$settings);
    }
    /**
     * @Route("/deleteSeries/{id}", name="deleteSeries")
     */
    public function deleteSeries($id,CRUD $CRUD){
        return $CRUD->delete($id,Series::class,'showSeries');
    }
    /**
     * @Route("/CreateSeries", name="CreateSeries")
     */
    public function CreateSeries(request $request,CRUD $CRUD){
        $settings=[
            'templete'=>'createitems/create.html.twig',
            'photoField'=>'avatar',
            'uplodUrl'=> 'series_directory',
            'twing' => [
                'title'=>'Create Series'
            ],
            'header'=>'showSeries'
        ];
        return $CRUD->create(SeriesType::class,new Series(),$request,$settings);
    }
}
