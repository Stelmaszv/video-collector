<?php
namespace App\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\SeriesRepository;
use App\Controller\AbstractnavigationController;
use App\Entity\Series;
use App\Form\SeriesType;
use App\Services\CRUD;
use Knp\Component\Pager\PaginatorInterface;
use App\Services\Pagination;
use App\Services\Settings\seriesSettings;
use App\Services\Settings\moviesSettings;
class SeriesController extends AbstractnavigationController
{   
    const itemtemolate='navigation/itemlist.html.twig';
    const moviestemplete='navigation/showmovies.htm.twig';
    const createtemplete='createitems/create.html.twig';
    const upload='series_directory';
    private $setings=[];
    function __construct(SeriesRepository $SeriesRepository,CRUD $CRUD,PaginatorInterface $paginator,Pagination $pagination){
        $this->setings['createtemplete']=self::createtemplete;
        $this->setings['itemtemolate']=self::itemtemolate;
        $this->setings['createForm']=SeriesType::class;
        $this->setings['EditForm']=SeriesType::class;
        $this->setings['entity']=new Series;
        $this->setings['upload']=self::upload;
        $this->setings['EditForm']=SeriesType::class;
        $this->setings['Form']=Series::class;
        $this->setings['Repository']=$SeriesRepository;
        $this->CRUD=$CRUD;

        //old stuff
        $this->paginator=$paginator;
        $this->pagination=$pagination;
        parent::__construct(new seriesSettings($this->setings));
    }
         /**
     * @Route("/faindSeries/{searchvalue}", name="faindSeries")
     */
    public function faindSeries(request $request){
        $this->setsetings->get($request,'reed');
        $this->setsetings->setValue('function','searchinRepository');
        $this->setsetings->setValue('functionarguments',[
            'searchvalue'=>$request->get('searchvalue'),
        ]);
        $data=$this->setsetings->returnSetings();
        return $this->reed($request,$data);
    }
       /**
     * @Route("/showSeries", name="showSeries")
     */
    public function showSeries(request $request){
        return $this->reed($request);
    }
            /**
     * @Route("/show_movies_in_series/{id}", name="show_movies_in_series")
     */
    public function show_movies_in_series(request $request){ 
        $moviesshema=new moviesSettings(); 
        $this->setsetings->get($request,'reed');
        $this->setsetings->setValue('templete',self::moviestemplete);
        $this->setsetings->setValue('function','getCollectionInEntity');
        $this->setsetings->setValue('functionarguments',[
            'getName'=>'Movies',
        ]);
        $this->setsetings->setValue('twing',$moviesshema->twingreedshema());
        $data=$this->setsetings->returnSetings();
        return $this->reed($request,$data);
    }
    /**
    * @Route("/editSeries/{id}", name="editSeries")
    */
    public function editSeries($id,request $request){
        return $this->updata($id,$request);
    }
    /**
     * @Route("/deleteSeries/{id}", name="deleteSeries")
     */
    public function deleteSeries($id,request $request){
        return $this->delete($id,'showSeries',$request);
    }
    /**
     * @Route("/CreateSeries", name="CreateSeries")
     */
    public function CreateSeries(request $request){
        return $this->create($request);
    }
}
