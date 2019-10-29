<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Services\CRUD;
use App\Form\TagsType;
use App\Entity\Tags;
use App\Repository\TagsRepository;
use App\Entity\Producent;

class CategoryController extends AbstractController
{
     /**
     * @Route("/show_movies_in_category/{id}", name="show_movies_in_category")
     */
    
    public function show_movies_in_category(Request $Request,TagsRepository $TagsRepository,CRUD $CRUD){
        $array=[
            'sectionName' =>'Show movies in category',
            'function'=>'getCollectionInEntity',
            'functionarguments'=>[
                'getName'=>'Movies',
            ],
            'id'=> $Request->get('id'),
            'templete'=>'navigation/showmovies.htm.twig',
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
     * @Route("/faindCategory/{searchvalue}", name="faindCategory")
     */
    public function faindCategory(TagsRepository $TagsRepository,CRUD $CRUD,Request $request){
        $array=[
            'function'=>'searchinRepository',
            'functionarguments'=>[
                'searchvalue'=>$request->get('searchvalue'),
            ],
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
     * @Route("/deleteTag/{id}", name="deleteTag")
     */
    public function deleteTag($id,CRUD $CRUD){
        return $CRUD->delete($id,Tags::class,'showCategory');
      }
    /**
     * @Route("/CreateTags", name="CreateTags")
     */
    public function CreateTags(Request $Request,CRUD $CRUD){
        $settings=[
            'templete'=>'createitems/create.html.twig',
            'photoField'=>'avatar',
            'uplodUrl'=> 'tag_directory',
            'twing' => [
                'title'=>'Create Category'
            ],
            'header'=>'showCategory'
        ];
        return $CRUD->create(TagsType::class, new Tags(),$Request,$settings);
    }
}
