<?php
namespace App\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Services\CRUD;
use App\Form\TagsType;
use App\Entity\Tags;
use App\Repository\TagsRepository;
use Knp\Component\Pager\PaginatorInterface;
use App\Services\Pagination;
use App\Controller\AbstractnavigationController;
use App\Services\Settings\tagsSettings;
use App\Services\Settings\moviesSettings;
class CategoryController extends AbstractnavigationController
{
     /**
     * @Route("/show_movies_in_category/{id}", name="show_movies_in_category")
     */
    const itemtemolate='navigation/itemlist.html.twig';
    const moviestemplete='navigation/showmovies.htm.twig';
    const createtemplete='createitems/create.html.twig';
    const upload='tag_directory';
    private $setings=[];
    function __construct(TagsRepository $TagsRepository,CRUD $CRUD,PaginatorInterface $paginator,Pagination $Pagination){
        $this->paginator=$paginator;
        $this->pagination=$Pagination;
        $this->setings['createtemplete']=self::createtemplete;
        $this->setings['itemtemolate']=self::itemtemolate;
        $this->setings['createForm']=TagsType::class;
        $this->setings['EditForm']=TagsType::class;
        $this->setings['entity']=new Tags;
        $this->setings['upload']=self::upload;
        $this->setings['EditForm']=TagsType::class;
        $this->setings['Form']=Tags::class;
        $this->setings['Repository']=$TagsRepository;
        $this->CRUD=$CRUD;
        parent::__construct(new tagsSettings($this->setings));
    }
    /**
     * @Route("/show_movies_in_category/{id}", name="show_movies_in_category")
     */
    public function show_movies_in_category(request $request){
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
     * @Route("/faindCategory/{searchvalue}", name="faindCategory")
     */
    public function faindCategory(request $request){
        $this->setsetings->get($request,'reed');
        $this->setsetings->setValue('function','searchinRepository');
        $this->setsetings->setValue('functionarguments',[
            'searchvalue'=>$request->get('searchvalue'),
        ]);
        $data=$this->setsetings->returnSetings();
        return $this->reed($request,$data);
    }
    /**
     * @Route("/showCategory", name="showCategory")
     */
    public function showCategory(request $request){
        return $this->reed($request);
    }
    /**
    * @Route("/editCategory/{id}", name="editCategory")
    */
    public function editCategory(request $request, $id){
        return $this->updata($id,$request);
    }
    /**
     * @Route("/deleteTag/{id}", name="deleteTag")
     */
    public function deleteTag(request $request, $id){
        return $this->delete($id,'showCategory',$request);
    }
    /**
     * @Route("/CreateTags", name="CreateTags")
     */
    public function CreateTags(request $request){
        return $this->create($request);
    }
    
}
