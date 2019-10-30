<?php
namespace App\Services;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Knp\Component\Pager\PaginatorInterface;
class Pagination extends AbstractController{
    private $function;
    private $obj;
    private $request;
    private $settings;
    public function paginate($settings,$paginator){
        $this->setItems($settings);
        if(isset($settings['id'])){
            return $this->faind($paginator);
        }else{
            return $this->normal($paginator);
        }
    }
    private function normal($paginator){
        $function=$this->function;
         $this->settings['results'] = $paginator->paginate(
            $this->obj->$function($this->settings['functionarguments']),
            $this->request->query->getInt('page', 1),2
        );
        return $this->twing();
    }
    private function faind($paginator){
        $this->settings['functionarguments']['item']=$this->obj->find($this->settings['id']);
        $function=$this->function;
        $this->settings['results'] = $paginator->paginate($this->obj->$function($this->settings['functionarguments']),$this->request->query->getInt('page', 1),2);
        return $this->twing();
    }
    private function returnArgumants(){
        if(isset($this->settings['functionarguments'])){
            return $this->settings['functionarguments'];
        }
        return false;
    }
    private function twing(){
        return $this->render($this->settings['templete'], [  
            'results'=>$this->settings['results'],
            'twing'  =>$this->settings['twing']
        ]); 
    }
    private function setItems(array $settings){
        $this->settings=$settings;
        $this->function=$settings['function'];
        $this->obj=$settings['Repository'];
        $this->request=$settings['request'];
    }
}