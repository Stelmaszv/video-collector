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
use App\Controller\AbstractnavigationController;
use App\Services\Settings\producentSettings;
use App\Services\Settings\seriesSettings;
class ProducentController extends AbstractnavigationController
{
    const itemtemolate='navigation/itemlist.html.twig';
    const moviestemplete='navigation/showmovies.htm.twig';
    const createtemplete='createitems/create.html.twig';
    const upload='producent_directory';
    private $setings=[];
    function __construct(ProducentRepository $ProducentRepository,CRUD $CRUD,PaginatorInterface $paginator,pagination $pagination){
        $this->setings['createtemplete']=self::createtemplete;
        $this->setings['itemtemolate']=self::itemtemolate;
        $this->setings['createForm']=PorducentEditType::class;
        $this->setings['EditForm']=PorducentEditType::class;
        $this->setings['entity']=new Producent;
        $this->setings['upload']=self::upload;
        $this->setings['EditForm']=PorducentEditType::class;
        $this->setings['Form']=Producent::class;
        $this->setings['Repository']=$ProducentRepository;
        $this->CRUD=$CRUD;
        $this->paginator=$paginator;
        $this->pagination=$pagination;
        parent::__construct(new producentSettings($this->setings)); 
    }
    /**
     * @Route("/show_series_in_producent/{id}", name="show_series_in_producent")
     */
    public function show_series_in_producent(request $request){
        $series=new seriesSettings;
        $this->setsetings->get($request,'reed');
        $this->setsetings->setValue('templete',self::itemtemolate);
        $this->setsetings->setValue('function','getCollectionInEntity');
        $this->setsetings->setValue('functionarguments',[
            'getName'=>'Series',
        ]);
        $this->setsetings->setValue('twing',$series->twingreedshema());
        $data=$this->setsetings->returnSetings();
        return $this->reed($request,$data);
    }
    /**
     * @Route("/faindProducents/{searchvalue}", name="faindProducents")
     */
    public function faindProducents(Request $request){
        $this->setsetings->get($request,'reed');
        $this->setsetings->setValue('templete',self::itemtemolate);
        $this->setsetings->setValue('function','searchinRepository');
        $this->setsetings->setValue('functionarguments',[
            'searchvalue'=>$request->get('searchvalue'),
        ]);
        $data=$this->setsetings->returnSetings();
        return $this->reed($request,$data);
    }
    /**
     * @Route("/showProducents", name="showProducents")
     */
    public function showProducent (Request $request){
        return $this->reed($request);
    }
        /**
    * @Route("/editProducent/{id}", name="editProducent")
    */
    public function editProducent($id,request $request){
        return $this->updata($id,$request);
    }
    /**
     * @Route("/deleteProducents/{id}", name="deleteProducents")
     */
    public function deleteProducents($id,request $request){
        return $this->delete($id,'showProducents',$request);
    }
    /**
     * @Route("/createProducent", name="createProducent")
     */
    public function CreateProducent(request $request){
        return $this->create($request);
    }
}
