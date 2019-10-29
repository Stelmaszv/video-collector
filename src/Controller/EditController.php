<?php

namespace App\Controller;
use App\Entity\Producent;
use App\Entity\Movies;
use App\Entity\Series;
use App\Entity\Tags;
use App\Entity\Stars;
use App\Form\PorducentEditType;
use App\Form\SeriesType;
use App\Form\TagsType;
use App\Form\StarsType;
use App\Form\MoviesType;
use App\Repository\ProducentRepository;
use App\Repository\SeriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Services\CRUD;
class EditController extends AbstractController{
    /**
    * @Route("/editMovies/{id}", name="editMovies")
    */
    public function editMovies(Request $request, $id,CRUD $CRUD){
        $settings=[
            'templete'=>'createitems/create.html.twig',
            'uplodUrl'=> 'series_directory',
            'twing' => [
                'title'=>'Edit Series'
            ]
        ];
        return $CRUD->updata(MoviesType::class,Movies::class,$request,$id,$settings);
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
    * @Route("/editProducent/{id}", name="editProducent")
    */
    public function editProducent(Request $request, $id,CRUD $CRUD){
        $settings=[
            'templete'=>'createitems/create.html.twig',
            'photoField'=>'avatar',
            'uplodUrl'=> 'series_directory',
            'twing' => [
                'title'=>'Edit Producent'
            ]
        ];
        return $CRUD->updata(PorducentEditType::class,Producent::class,$request,$id,$settings);
    }
    /**
    * @Route("/editCategory/{id}", name="editCategory")
    */
    public function editCategory(Request $request, $id,CRUD $CRUD){
        $settings=[
            'templete'=>'createitems/create.html.twig',
            'photoField'=>'avatar',
            'uplodUrl'=> 'tag_directory',
            'twing' => [
                'title'=>'Edit Category'
            ]
        ];
        return $CRUD->updata(TagsType::class,Tags::class,$request,$id,$settings);
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
}
