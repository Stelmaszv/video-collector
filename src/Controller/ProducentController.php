<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ProducentRepository;
use App\Services\CRUD;
use App\Entity\Producent;
use App\Form\PorducentEditType;


class ProducentController extends AbstractController
{
        /**
     * @Route("/show_series_in_producent/{id}", name="show_series_in_producent")
     */
    public function show_series_in_producent(Request $Request,ProducentRepository $ProducentRepository,CRUD $CRUD){
        $array=[
            'function'=>'getCollectionInEntity',
            'id'=> $Request->get('id'),
            'functionarguments'=>[
                'getName'=>'Series'
            ],
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
     * @Route("/faindProducents/{searchvalue}", name="faindProducents")
     */
    public function faindProducents(ProducentRepository $ProducentRepository,Request $request,CRUD $CRUD)
    {
        $array=[
            'function'=>'searchinRepository',
            'functionarguments'=>[
                'searchvalue'=>$request->get('searchvalue'),
            ],
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
     * @Route("/showProducents", name="showProducents")
     */
    public function showProducent (ProducentRepository $ProducentRepository,CRUD $CRUD){
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
            'templete'=>'createitems/create.html.twig',
            'photoField'=>'avatar',
            'uplodUrl'=> 'producent_directory',
            'twing' => [
                'title'=>'Create Producent'
            ],
            'header'=>'showProducents'
        ];
        return $CRUD->create(PorducentEditType::class, new Producent(),$Request,$settings);
    }
}
