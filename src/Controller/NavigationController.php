<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\MoviesRepository;
use App\Repository\ProducentRepository;
use App\Repository\SeriesRepository;
use App\Repository\StarsRepository;
use App\Repository\TagsRepository;
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
    public function show_movies_with_star(Request $Request,StarsRepository $StarsRepository){
        $array=[
            'function'=>'findInRepository',
            'functionInRepository'=>'getCollectionInEntity',
            'getName'=>'Movies',
            'id'=> $Request->get('id'),
            'templete'=>'navigation/showmovies.htm.twig',
            'photourl'=>'',
            'url'     =>'show_movie',
            'sectionName' =>'Star dqd'
            
        ];
        return $this->navigationSetsection($StarsRepository,$array);
    }
    /**
     * @Route("/show_movies_in_category/{id}", name="show_movies_in_category")
     */
    
    public function show_movies_in_category(Request $Request,TagsRepository $TagsRepository){
        $array=[
            'sectionName' =>'Show movies in category',
            'function'=>'findInRepository',
            'functionInRepository'=>'getCollectionInEntity',
            'getName'=>'Movies',
            'id'=> $Request->get('id'),
            'templete'=>'navigation/movielist.html.twig',
            'photourl'=>'',
            'url'     =>'show_movie',
        ];
        return $this->navigationSetsection($TagsRepository,$array);
    }
    /**
     * @Route("/showStars", name="showStars")
    */
    
    public function showStars(StarsRepository $StarsRepository){
        $array=[
            'function'    =>'findAll',
            'photourl'    =>'stars',
            'templete'    =>'navigation/itemlist.html.twig',
            'url'         =>'show_movies_with_star',
            'sectionName' =>'series'
        ];
        return $this->navigationSetsection($StarsRepository,$array);
    }
       /**
     * @Route("/showCategory", name="showCategory")
     */
    public function showCategory(TagsRepository $TagsRepository){
        $array=[
            'function'=>'findAll',
            'photourl'=>'tags',
            'sectionName' =>'Category',
            'templete'=>'navigation/itemlist.html.twig',
            'url'     =>'show_movies_in_category'
        ];
        return $this->navigationSetsection($TagsRepository,$array);
    }
       /**
     * @Route("/showSeries", name="showSeries")
     */
    public function showSeries(SeriesRepository $SeriesRepository){
        $array=[
            'function'=>'findAll',
            'photourl'=>'series',
            'sectionName' =>'Series',
            'templete'=>'navigation/itemlist.html.twig',
            'url'     =>'show_movies_in_series'
        ];
        return $this->navigationSetsection($SeriesRepository,$array);
    }
    /**
     * @Route("/", name="main")
     */
    public function showMovies (MoviesRepository $MoviesRepository){
        $array=[
            'function'=>'findAll',
            'templete'=>'navigation/showmovies.htm.twig',
            'photourl'=>'',
            'sectionName' =>'Movies',
            'url'     =>'show_movie'
        ];
        return $this->navigationSetsection($MoviesRepository,$array);
    }
        /**
     * @Route("/showProducents", name="showProducents")
     */
    public function showProducents (ProducentRepository $ProducentRepository){
        $array=[
            'function'=>'findAll',
            'templete'=>'navigation/itemlist.html.twig',
            'photourl'=>'producent',
            'sectionName' =>'Producents',
            'url'     =>'show_series_in_producent',
            'editLink'=>'editProducent',
            'deleteLink'=>'deleteProducent'
        ];
        return $this->navigationSetsection($ProducentRepository,$array);
    }
    /**
     * @Route("/show_series_in_producent/{id}", name="show_series_in_producent")
     */
    public function show_series_in_producent(Request $Request,ProducentRepository $ProducentRepository){
        $array=[
            'function'=>'findInRepository',
            'functionInRepository'=>'getCollectionInEntity',
            'id'=> $Request->get('id'),
            'getName'=>'Series',
            'templete'=>'navigation/itemlist.html.twig',
            'photourl'=>'series',
            'url'     =>'show_movies_in_series',
            'sectionName' =>'Movies in series',
        ];
        return $this->navigationSetsection($ProducentRepository,$array);
    }
        /**
     * @Route("/show_movies_in_series/{id}", name="show_movies_in_series")
     */
    public function show_movies_in_series(Request $Request,SeriesRepository $SeriesRepository){
        $array=[
            'function'=>'findInRepository',
            'functionInRepository'=>'getCollectionInEntity',
            'id'=> $Request->get('id'),
            'templete'=>'navigation/movielist.html.twig',
            'photourl'=>'series',
            'getName'=>'Movies',
            'url'     =>'show_movie',
            'sectionName' =>'Movies in series',
        ];
        return $this->navigationSetsection($SeriesRepository,$array);
    }
    private function navigationSetsection($obj,$array){
        $function=$array['function'];
        return $this->$function($obj,$array);
    }
    private function findAll($obj,$array){
        $items=$obj->findAll();
        return $this->render($array['templete'], [
            'items'=>$items,
            'photourl'=>$array['photourl'],
            'url'=>$array['url'],
            'sectionName' =>$array['sectionName'],
            'editLink'=>$array['editLink'],
            'deleteLink'=>$array['deleteLink']
        ]);
    }
    private function find($obj,$array){
        $item=$obj->find($array['id']);
        return $this->render($array['templete'], [
           'movie'=>$item
        ]);
    }
    private function findInRepository($obj,$array){
        $Repositorylist=[];
        $item=$obj->find($array['id']);
        $function=$array['functionInRepository'];
        $Repositorylist=$obj->$function($item,$array['getName']);
        return $this->render($array['templete'], [
            'items'=>$Repositorylist,
            'photourl'=>$array['photourl'],
            'url'=>$array['url'],
            'sectionName' =>$array['sectionName']
        ]);
    }

}
