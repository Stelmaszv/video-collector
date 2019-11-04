<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Services\CRUD;
use Symfony\Component\HttpFoundation\Request;
use App\Services\Settings\settingSet;
abstract class AbstractnavigationController extends AbstractController{
    public $setsetings;
    protected $edit;
    protected $create;
    protected $reed;
    private $setingsArray=[];
    const itemtemolate='navigation/itemlist.html.twig';
    function __construct(object $seriesSettings){
        // implemenation of strategy for use settings
        $setting=new settingSet();
        $this->setsetings=$setting->set($seriesSettings);
    }
    function create($request){
        $this->create=$this->setsetings->get($request,'create');
        return $this->CRUD->create($this->create);
    }
    function updata($id,$request){
        $this->edit=$this->setsetings->get($request,'edit');
        return $this->CRUD->updata($id,$this->edit);
    }
    function reed(request $request,$data=false){
        if(!$data){
            $this->reed=$this->setsetings->get($request,'reed'); 
        } else{
            $this->reed=$data; 
        }
        return $this->CRUD->reed($this->reed,$this->paginator,$this->pagination);
    }
    public function delete($id,$heder,$request){
        $this->reed=$this->setsetings->get($request,'delete'); 
        return $this->CRUD->delete($id,$heder,$this->reed);
    }
    private function classname(){
        return (new \ReflectionClass($this))->getShortName();
    }

}
