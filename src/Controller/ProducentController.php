<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ProducentRepository;
use App\Services\CRUD;
use App\Entity\Producent;
use App\Form\PorducentEditType;
use Knp\Component\Pager\PaginatorInterface;
use App\Services\Pagination;

class ProducentController extends AbstractController
{

    const itemtemolate='navigation/itemlist.html.twig';
    const moviestemplete='navigation/showmovies.htm.twig';
    const createtemplete='createitems/create.html.twig';
    const upload='producent_directory';
    function __construct(ProducentRepository $ProducentRepository,CRUD $CRUD,PaginatorInterface $paginator,Pagination $Pagination){
        $this->Repository=$ProducentRepository;
        $this->CRUD=$CRUD;
        $this->paginator=$paginator;
        $this->pagination=$Pagination;
        $this->Entity=new Producent;
        $this->CreateForm=PorducentEditType::class;
        $this->EditForm=PorducentEditType::class;
        $this->Form=Producent::class;
    }
    /**
     * @Route("/show_series_in_producent/{id}", name="show_series_in_producent")
     */
    public function show_series_in_producent(request $request){
        $array=[
            'function'           => 'getCollectionInEntity',
            'id'=> $request->get('id'),
            'functionarguments'=>[
                  'getName'=>'Series'
            ],
            'pagination'         => true,
            'Repository'         => $this->Repository,
            'request'            => $request,
            'templete'           => self::itemtemolate,
            'twing' => [
                'photourl'=>'producent',
                'sectionName' =>'Series in Producent',
                'editLink'    =>'editStars',
                'deleteLink'  =>'deleteMovie',
                'url'         =>'show_movies_in_series',
            ]
        ];
        return $this->CRUD->reed($array,$this->paginator,$this->pagination);
    }
    /**
     * @Route("/faindProducents/{searchvalue}", name="faindProducents")
     */
    public function faindProducents(Request $request){
        $array=[
            'function'           => 'searchinRepository',
            'pagination'         =>true,
            'functionarguments'  =>[
                'searchvalue'=>$request->get('searchvalue'),
            ],
            'Repository'         => $this->Repository,
            'request'            => $request,
            'templete'           => self::itemtemolate,
            'twing'              => [
                'photourl'       =>'producent',
                'sectionName'    =>'Producents like "'.$request->get('searchvalue').'"',
                'editLink'       =>'editProducent',
                'deleteLink'     =>'deleteProducents',
                'url'            =>'show_series_in_producent',
            ]
        ];
        return $this->CRUD->reed($array,$this->paginator,$this->pagination);
    }
    /**
     * @Route("/showProducents", name="showProducents")
     */
    public function showProducent (Request $request){
        $array=[
            'function'           => 'findAll',
            'pagination'=>true,
            'functionarguments'  => [],
            'Repository'         => $this->Repository,
            'request'            => $request,
            'templete'           => self::itemtemolate,
            'twing' => [
                'photourl'=>'producent',
                'title'=>'Edit Series',
                'sectionName' =>'Producents',
                'editLink'    =>'editProducent',
                'deleteLink'  =>'deleteProducents',
                'url'         =>'show_series_in_producent',
            ]
        ];
        return $this->CRUD->reed($array,$this->paginator,$this->pagination);
    }
        /**
    * @Route("/editProducent/{id}", name="editProducent")
    */
    public function editProducent(Request $request, $id,CRUD $CRUD){
        $settings=[
            'templete'   => self::createtemplete,
            'photoField' => 'avatar',
            'uplodUrl'   => self::upload,
            'twing'      => [
                'title'=>'Edit Producent'
            ]
        ];
        return $CRUD->updata(PorducentEditType::class,Producent::class,$request,$id,$settings);
    }
    /**
     * @Route("/deleteProducents/{id}", name="deleteProducents")
     */
    public function deleteProducents($id,CRUD $CRUD){
        return $CRUD->delete($id,Producent::class,'showProducents');
    }
    /**
     * @Route("/createProducent", name="createProducent")
     */
    public function CreateProducent(Request $Request,CRUD $CRUD){
        $settings=[
            'templete'  => self::createtemplete,
            'photoField'=> 'avatar',
            'uplodUrl'  => self::upload,
            'twing' => [
                'title'=>'Create Producent'
            ],
            'header'=>'showProducents'
        ];
        return $CRUD->create(PorducentEditType::class, new Producent(),$Request,$settings);
    }
}
