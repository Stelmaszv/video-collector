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
    const limitOnPage=8;
    public function paginate($settings,$paginator){
        $this->setItems($settings);
        $request=$this->settings['request'];
        if($request->get('id')!==NULL){
            return $this->faind($paginator);
        }else{
            return $this->normal($paginator);
        }
    }
    private function normal($paginator){
        $function=$this->function;
         $this->settings['results'] = $paginator->paginate(
            $this->obj->$function($this->settings['functionarguments']),
            $this->request->query->getInt('page', 1),self::limitOnPage
        );
        return $this->twing();
    }
    private function faind($paginator){
        $request=$this->settings['request'];
        $this->settings['functionarguments']['item']=$this->obj->find($request->get('id'));
        $function=$this->function;
        $this->settings['results'] = $paginator->paginate($this->obj->$function($this->settings['functionarguments']),$this->request->query->getInt('page', 1),self::limitOnPage);
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