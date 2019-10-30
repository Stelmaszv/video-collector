<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\SeriesRepository;
use App\Entity\Series;
use App\Form\SeriesType;
use App\Services\CRUD;
use Knp\Component\Pager\PaginatorInterface;
use App\Services\Pagination;
class SeriesController extends AbstractController
{   
    const itemtemolate='navigation/itemlist.html.twig';
    const moviestemplete='navigation/showmovies.htm.twig';
    const createtemplete='createitems/create.html.twig';
    const upload='series_directory';
    function __construct(SeriesRepository $SeriesRepository,CRUD $CRUD,PaginatorInterface $paginator,Pagination $Pagination){
        $this->Repository=$SeriesRepository;
        $this->CRUD=$CRUD;
        $this->paginator=$paginator;
        $this->pagination=$Pagination;
        $this->Entity=new Series;
        $this->CreateForm=SeriesType::class;
        $this->EditForm=SeriesType::class;
        $this->Form=Series::class;
    }
         /**
     * @Route("/faindSeries/{searchvalue}", name="faindSeries")
     */
    public function faindSeries(request $request){
        $array=[
            'function'=>'searchinRepository',
            'pagination'=>true,
            'functionarguments'=>[
                'searchvalue'=>$request->get('searchvalue'),
            ],
            'templete'      =>self::itemtemolate,
            'Repository'    => $this->Repository,
            'request'       => $request,
            'twing' => [
                'photourl'    =>'series',
                'title'       =>'Edit Series',
                'sectionName' =>'Series',
                'editLink'    =>'editSeries',
                'deleteLink'  =>'deleteSeries',
                'url'         =>'show_movies_with_star',
            ]
        ];
        return $this->CRUD->reed($array,$this->paginator,$this->pagination);
    }
       /**
     * @Route("/showSeries", name="showSeries")
     */
    public function showSeries(request $request){
        $array=[
            'function'=>'findAll',
            'pagination'=>true,
            'templete'=>self::itemtemolate,
            'functionarguments'=>[],
            'Repository'    => $this->Repository,
            'request'      => $request,
            'twing' => [
                'photourl'    =>'series',
                'title'       =>'Edit Series',
                'sectionName' =>'Series',
                'editLink'    =>'editSeries',
                'deleteLink'  =>'deleteSeries',
                'url'         =>'show_movies_in_series',
            ]
        ];        
        return $this->CRUD->reed($array,$this->paginator,$this->pagination);
    }
            /**
     * @Route("/show_movies_in_series/{id}", name="show_movies_in_series")
     */
    public function show_movies_in_series(request $request){  
        $array=[
            'function'=>'getCollectionInEntity',
            'pagination'=>true,
            'Repository'    => $this->Repository,
            'request'      => $request,
            'id'=> $request->get('id'),
            'templete'=>self::moviestemplete,
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
        //return $CRUD->reed($SeriesRepository,$array);     
        return $this->CRUD->reed($array,$this->paginator,$this->pagination);
    }
    /**
    * @Route("/editSeries/{id}", name="editSeries")
    */
    public function editSeries(Request $request, $id){
        $settings=[
            'templete'=>self::createtemplete,
            'photoField'=>'avatar',
            'uplodUrl'=> self::upload,
            'twing' => [
                'title'=>'Edit Series'
            ]
        ];
        return $this->CRUD->updata($this->EditForm,$this->Form,$request,$id,$settings);
    }
    /**
     * @Route("/deleteSeries/{id}", name="deleteSeries")
     */
    public function deleteSeries($id){
        return $this->CRUD->delete($id,$this->Form,'showSeries');
    }
    /**
     * @Route("/CreateSeries", name="CreateSeries")
     */
    public function CreateSeries(request $request){
        $settings=[
            'templete'=>self::createtemplete,
            'photoField'=>'avatar',
            'uplodUrl'=> self::upload,
            'twing' => [
                'title'=>'Create Series'
            ],
            'header'=>'showSeries'
        ];
        return $this->CRUD->create($this->CreateForm,$this->Entity,$request,$settings);
    }
}
