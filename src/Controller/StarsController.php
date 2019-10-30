<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\StarsRepository;
use App\Services\CRUD;
use App\Entity\Stars;
use App\Form\StarsType;
use Knp\Component\Pager\PaginatorInterface;
use App\Services\Pagination;
class StarsController extends AbstractController
{   
    const itemtemolate='navigation/itemlist.html.twig';
    const moviestemplete='navigation/showmovies.htm.twig';
    const createtemplete='createitems/create.html.twig';
    const upload='stars_directory';
    function __construct(StarsRepository $StarsRepository,CRUD $CRUD,PaginatorInterface $paginator,Pagination $Pagination){
        $this->Repository=$StarsRepository;
        $this->CRUD=$CRUD;
        $this->paginator=$paginator;
        $this->pagination=$Pagination;
        $this->Entity=new Stars;
        $this->CreateForm=StarsType::class;
        $this->EditForm=StarsType::class;
        $this->Form=Stars::class;
    }
    /**
     * @Route("/faindStars/{searchvalue}", name="faindStars")
    */
    public function faindStars(request $request){
        $array=[
            'function'=>'searchinRepository',
            'functionarguments'=>[
                'searchvalue'=>$request->get('searchvalue'),
            ],
            'request'       => $request,
            'Repository'    => $this->Repository,
            'pagination'    =>true,
            'templete'      =>self::itemtemolate,
            'photoField'    =>'avatar',
            'twing' => [
                'photourl'    =>'stars',
                'title'       =>'Edit Series',
                'sectionName' =>'Stars',
                'editLink'    =>'editStars',
                'deleteLink'  =>'deleteStar',
                'url'         =>'show_movies_with_star',
            ]
        ];
        
        return $this->CRUD->reed($array,$this->paginator,$this->pagination);
    }
    /**
     * @Route("/showStars", name="showStars")
    */
    
    public function showStars(request $request){
        $array=[
            'function'    =>'findAll',
            'pagination'=>true,
            'functionarguments'=>[ ],
            'Repository'    => $this->Repository,
            'request'      => $request,
            'templete'=>self::itemtemolate,
            'photoField'=>'avatar',
            'uplodUrl'=> self::upload,
            'twing' => [
                'photourl'    =>'stars',
                'title'       =>'Edit Series',
                'sectionName' =>'Stars',
                'editLink'    =>'editStars',
                'deleteLink'  =>'deleteStar',
                'url'         =>'show_movies_with_star',
            ]
        ];
        
        return $this->CRUD->reed($array,$this->paginator,$this->pagination);
    }
    /**
     * @Route("/show_movies_with_star/{id}", name="show_movies_with_star")
     */
    public function show_movies_with_star(Request $Request){
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
                'title'=>'Edit Series',
                'sectionName' =>'Show Movie with Star',
                'editLink'    =>'editStars',
                'deleteLink'  =>'deleteMovie',
                'url'         =>'show_movie',
            ]
            
        ];
        return $this->CRUD->reed($array,$this->paginator,$this->pagination);
    }
    /**
    * @Route("/editStars/{id}", name="editStars")
    */
    public function editStars(Request $request, $id){
        $settings=[
            'templete'=>self::createtemplete,
            'photoField'=>'avatar',
            'uplodUrl'=> self::upload,
            'twing' => [
                'title'=>'Edit Stars'
            ]
        ];
        return $this->CRUD->updata($this->EditForm,$this->Form,$request,$id,$settings);
    }
    /**
     * @Route("/deleteStar/{id}", name="deleteStar")
     */
    public function deleteStar($id,CRUD $CRUD){
        return $CRUD->delete($id,$this->Form,'showStars');
      }
    /**
     * @Route("/createStars", name="createStars")
     */
    public function createStars(Request $Request,CRUD $CRUD){
        $settings=[
            'templete'=>self::createtemplete,
            'photoField'=>'avatar',
            'uplodUrl'=> self::upload,
            'twing' => [
                'title'=>'Create Star'
            ],
            'header'=>'showStars'
        ];
        return $CRUD->create($this->CreateForm, $this->Entity,$Request,$settings);
    }
}
