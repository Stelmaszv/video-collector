<?php
namespace App\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\StarsRepository;
use App\Services\CRUD;
use App\Entity\Stars;
use App\Form\StarsType;
use Knp\Component\Pager\PaginatorInterface;
use App\Services\Pagination;
use App\Controller\AbstractnavigationController;
use App\Services\Settings\starsSettings;
use App\Services\Settings\moviesSettings;
class StarsController extends AbstractnavigationController
{   
    const itemtemolate='navigation/itemlist.html.twig';
    const moviestemplete='navigation/showmovies.htm.twig';
    const createtemplete='createitems/create.html.twig';
    const upload='stars_directory';
    function __construct(StarsRepository $StarsRepository,CRUD $CRUD,PaginatorInterface $paginator,Pagination $Pagination){
        
        $this->CRUD=$CRUD;
        $this->paginator=$paginator;
        $this->pagination=$Pagination;
        $this->setings['createtemplete']=self::createtemplete;
        $this->setings['itemtemolate']=self::itemtemolate;
        $this->setings['createForm']=StarsType::class;
        $this->setings['EditForm']=StarsType::class;
        $this->setings['entity']=new Stars;
        $this->setings['upload']=self::upload;
        $this->setings['EditForm']=StarsType::class;
        $this->setings['Form']=Stars::class;
        $this->setings['Repository']=$StarsRepository;
        parent::__construct(new starsSettings($this->setings)); 
    }
    /**
     * @Route("/faindStars/{searchvalue}", name="faindStars")
    */
    public function faindStars(request $request){
        $this->setsetings->get($request,'reed');
        $this->setsetings->setValue('function','searchinRepository');
        $this->setsetings->setValue('functionarguments',[
            'searchvalue'=>$request->get('searchvalue'),
        ]);
        $data=$this->setsetings->returnSetings();
        return $this->reed($request,$data);
    }
    /**
     * @Route("/showStars", name="showStars")
    */
    
    public function showStars(request $request){
        return $this->reed($request);
    }
    /**
     * @Route("/show_movies_with_star/{id}", name="show_movies_with_star")
     */
    public function show_movies_with_star(request $request){
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
    * @Route("/editStars/{id}", name="editStars")
    */
    public function editStars($id,Request $request){
        return $this->updata($id,$request);
    }
    /**
     * @Route("/deleteStar/{id}", name="deleteStar")
     */
    public function deleteStar($id,request $request){
        return $this->delete($id,'showStars',$request);
      }
    /**
     * @Route("/createStars", name="createStars")
     */
    public function createStars(Request $request){
        return $this->create($request);
    }
}
