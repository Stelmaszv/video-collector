<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\MoviesRepository;
use App\Repository\ProducentRepository;
use App\Repository\SeriesRepository;
use App\Repository\StarsRepository;
use App\Repository\TagsRepository;
use App\Services\CRUD;
use Symfony\Component\HttpFoundation\Request;

class NavigationController extends AbstractController{
      
     /**
     * @Route("/show_movie/{id}", name="show_movie")
     */
    
    public function show_movie(Request $Request,MoviesRepository $MoviesRepository){
        $item=$MoviesRepository->find($Request->get('id'));
        $tags=$MoviesRepository->getCollectionInEntity($item,'Tags');
        $stars=$MoviesRepository->getCollectionInEntity($item,'Stars');
        $stars_in_movies=$MoviesRepository->getMoviesWithStars($item,$stars,$Request->get('id'));
        $tags_in_movies=$MoviesRepository->getMoviesWithTags($item,$tags,$Request->get('id'));
        $movies_in_series=$MoviesRepository->getMoviesInSeries($item,$Request->get('id'));
        return $this->render('navigation/show_movie.htm.twig', [
            'stars'=>$stars,
            'movie'=>$item,
            'tags' =>$tags,
            'stars_in_movies' => $stars_in_movies,
            'tags_in_movies'  => $tags_in_movies,
            'movies_in_serie' => $movies_in_series
        ]);
    }
    /**
     * @Route("/show_movies_with_star/{id}", name="show_movies_with_star")
     */
    public function show_movies_with_star(Request $Request,StarsRepository $StarsRepository,CRUD $CRUD){
        $array=[
            'function'=>'getCollectionInEntity',
            'getName'=>'Movies',
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
                'url'         =>'show_movies_with_star',
            ]
            
        ];
        return $CRUD->reed($StarsRepository,$array);
    }
    /**
     * @Route("/show_movies_in_category/{id}", name="show_movies_in_category")
     */
    
    public function show_movies_in_category(Request $Request,TagsRepository $TagsRepository,CRUD $CRUD){
        $array=[
            'sectionName' =>'Show movies in category',
            'function'=>'getCollectionInEntity',
            'getName'=>'Movies',
            'id'=> $Request->get('id'),
            'templete'=>'navigation/movielist.html.twig',
            'photourl'=>'',
            'url'     =>'show_movie',
            'editLink'=>'editProducent',
            'deleteLink'=>'deleteMovie',
            'uplodUrl'=> 'series_directory',
            'twing' => [
                'photourl'    =>'stars',
                'title'       =>'Edit Series',
                'sectionName' =>'Movies',
                'editLink'    =>'editMovies',
                'deleteLink'  =>'deleteMovie',
                'url'         =>'show_movies_with_star',
            ]
        ];
        return $CRUD->reed($TagsRepository,$array);
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
     * @Route("/showCategory", name="showCategory")
     */
    public function showCategory(TagsRepository $TagsRepository,CRUD $CRUD){
        $array=[
            'function'=>'findAll',
            'templete'=>'navigation/itemlist.html.twig',
            'url'     =>'show_movies_in_category',
            'editLink'=>'editStars',
            'deleteLink'=>'deleteMovie',
            'twing' => [
                'photourl'=>'tags',
                'title'=>'Edit Series',
                'sectionName' =>'Category',
                'editLink'    =>'editCategory',
                'deleteLink'  =>'deleteTag',
                'url'         =>'show_movies_in_category',
            ]
        ];
        return $CRUD->reed($TagsRepository,$array);
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
     * @Route("/", name="main")
     */
    public function showMovies (MoviesRepository $MoviesRepository,CRUD $CRUD){
        $array=[
            'function'=>'findAll',
            'templete'=>'navigation/showmovies.htm.twig',
            'photourl'=>'',
            'sectionName' =>'Movies',
            'url'     =>'show_movie',
            'editLink'=>'editSeries',
            'deleteLink'=>'deleteMovie',
            'twing' => [
                'title'       =>'Edit Series',
                'sectionName' =>'Movies',
                'editLink'    =>'editMovies',
                'deleteLink'  =>'deleteMovie',
                'url'         =>'show_movie',
            ]
        ];
        return $CRUD->reed($MoviesRepository,$array);
    }
        /**
     * @Route("/showProducents", name="showProducents")
     */
    public function showProducents (ProducentRepository $ProducentRepository,CRUD $CRUD){
        $array=[
            'function'=>'findAll',
            'templete'=>'navigation/itemlist.html.twig',
            'twing' => [
                'photourl'=>'producent',
                'title'=>'Edit Series',
                'sectionName' =>'Producents',
                'editLink'    =>'editProducent',
                'deleteLink'  =>'deleteProducents',
                'url'         =>'show_series_in_producent',
            ]
        ];
        return $CRUD->reed($ProducentRepository,$array);
    }
    /**
     * @Route("/show_series_in_producent/{id}", name="show_series_in_producent")
     */
    public function show_series_in_producent(Request $Request,ProducentRepository $ProducentRepository,CRUD $CRUD){
        $array=[
            'function'=>'getCollectionInEntity',
            'id'=> $Request->get('id'),
            'getName'=>'Series',
            'templete'=>'navigation/itemlist.html.twig',
            'url'     =>'show_movies_in_series',
            'sectionName' =>'Movies in series',
            'editLink'=>'editSeries',
            'deleteLink'=>'deleteMovie',
            'twing' => [
                'photourl'=>'series',
                'title'=>'Edit Series',
                'sectionName' =>'series',
                'editLink'    =>'editStars',
                'deleteLink'  =>'deleteMovie',
                'url'         =>'show_movies_in_series',
            ]
        ];
        return $CRUD->reed($ProducentRepository,$array);
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
            'getName'=>'Movies',
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
}
