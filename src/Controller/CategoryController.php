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
use Knp\Component\Pager\PaginatorInterface;
use App\Services\Pagination;

class CategoryController extends AbstractController
{
     /**
     * @Route("/show_movies_in_category/{id}", name="show_movies_in_category")
     */
    const itemtemolate='navigation/itemlist.html.twig';
    const moviestemplete='navigation/showmovies.htm.twig';
    const createtemplete='createitems/create.html.twig';
    const upload='tag_directory';
    function __construct(TagsRepository $TagsRepository,CRUD $CRUD,PaginatorInterface $paginator,Pagination $Pagination){
        $this->Repository=$TagsRepository;
        $this->CRUD=$CRUD;
        $this->paginator=$paginator;
        $this->pagination=$Pagination;
        $this->Entity=new Tags;
        $this->CreateForm=TagsType::class;
        $this->EditForm=TagsType::class;
        $this->Form=Tags::class;
    }
    /**
     * @Route("/show_movies_in_category/{id}", name="show_movies_in_category")
     */
    public function show_movies_in_category(Request $Request){
        $array=[
            'function'=>'getCollectionInEntity',
            'functionarguments'=>[
                'getName'=>'Movies',
            ],
            'pagination'=>true,
            'Repository'    => $this->Repository,
            'request'      => $Request,
            'id'=> $Request->get('id'),
            'templete'=>self::moviestemplete,
            'photourl'=>'',
            'twing' => [
                'photourl'    =>'stars',
                'sectionName' =>'Show movies in category',
                'editLink'    =>'editMovies',
                'deleteLink'  =>'deleteMovie',
                'url'         =>'show_movie',
            ]
        ];
        return $this->CRUD->reed($array,$this->paginator,$this->pagination);
    }
    /**
     * @Route("/faindCategory/{searchvalue}", name="faindCategory")
     */
    public function faindCategory(Request $Request){
        $array=[
            'function'=>'searchinRepository',
            'functionarguments'=>[
                'searchvalue'=>$request->get('searchvalue'),
            ],
            'pagination'=>true,
            'Repository'    => $this->Repository,
            'request'      => $Request,
            'templete'=>'navigation/itemlist.html.twig',
            'twing' => [
                'photourl'=>'tags',
                'title'=>'Edit Series',
                'sectionName' =>'Category',
                'editLink'    =>'editCategory',
                'deleteLink'  =>'deleteTag',
                'url'         =>'show_movies_in_category',
            ]
        ];
        return $this->CRUD->reed($array,$this->paginator,$this->pagination);
    }
    /**
     * @Route("/showCategory", name="showCategory")
     */
    public function showCategory(Request $Request){
        $array=[
            'function'=>'findAll',
            'functionarguments'=>[],
            'pagination'=>true,
            'Repository'    => $this->Repository,
            'request'      => $Request,
            'templete'=>self::itemtemolate,
            'twing' => [
                'photourl'=>'tags',
                'title'=>'Edit Series',
                'sectionName' =>'Category',
                'editLink'    =>'editCategory',
                'deleteLink'  =>'deleteTag',
                'url'         =>'show_movies_in_category',
            ]
        ];
        return $this->CRUD->reed($array,$this->paginator,$this->pagination);
    }
    /**
    * @Route("/editCategory/{id}", name="editCategory")
    */
    public function editCategory(Request $request, $id,CRUD $CRUD){
        $settings=[
            'templete'=>self::createtemplete,
            'photoField'=>'avatar',
            'uplodUrl'=> self::upload,
            'twing' => [
                'title'=>'Edit Category'
            ]
        ];
        return $CRUD->updata($this->EditForm,$this->Form,$request,$id,$settings);
    }
    /**
     * @Route("/deleteTag/{id}", name="deleteTag")
     */
    public function deleteTag($id,CRUD $CRUD){
        return $CRUD->delete($id,$this->Form,'showCategory');
      }
    /**
     * @Route("/CreateTags", name="CreateTags")
     */
    public function CreateTags(Request $Request,CRUD $CRUD){
        $settings=[
            'templete'=>self::createtemplete,
            'photoField'=>'avatar',
            'uplodUrl'=> self::upload,
            'twing' => [
                'title'=>'Create Category'
            ],
            'header'=>'showCategory'
        ];
        return $CRUD->create($this->CreateForm, $this->Entity,$Request,$settings);
    }
}
