<?php
namespace App\Services\Settings;
use Symfony\Component\Config\Definition\Exception\Exception;
abstract class abstractNavigationSettings{
    protected $settingsArray;
    protected $set;
    protected $settings;
    abstract function get($reguest,string $name);
    abstract function twingreedshema();
    function __construct($setting=false){
        $this->settingsArray=$setting;
    }
    protected function createwithphoto(object $request,string $header,string $title){
        return $this->addphoto('avatar',$this->create($request,$header,$title));
    }
    protected function create(object $request,string $header,string $title){
        return ['templete'             => $this->settingsArray['createtemplete'],
            'form'                     => $this->settingsArray['createForm'],
            'request'                  => $request,
            'entity'                   => $this->settingsArray['entity'],
            'uplodUrl'                 => $this->settingsArray['upload'],
            'Repository'               => $this->settingsArray['Repository'],
            'twing'                    => [
                'title'                => $title
            ],
            'header'                   => $header];
    }
    protected function delete(){
        return [ 
            'repository'               =>$this->settingsArray['Form'],
            'entity'                   =>$this->settingsArray['entity']
        ];
    }
    protected function editwithphoto(object $request,string $title){
        return $this->addphoto('avatar',$this->edit($request,$title));
    }
    protected function edit(object $request,string $title){
        return[
            'templete'                 =>$this->settingsArray['createtemplete'],
            'entityEdit'               =>$this->settingsArray['Form'],
            'form'                     =>$this->settingsArray['EditForm'],
            'repository'               =>$this->settingsArray['Repository'],
            'request'                  =>$request,
            'uplodUrl'                 =>$this->settingsArray['upload'],
            'twing'                    =>[
                'title'                =>$title
            ],
        ];
    }
    protected function reed(object $request){
        return [
            'function'                 => 'findAll',
            'pagination'               => true,
            'templete'                 => $this->settingsArray['itemtemolate'],
            'functionarguments'        => [],
            'Repository'               => $this->settingsArray['Repository'],
            'request'                  => $request,
            'twing'                    => $this->twingreedshema()
        ];
    }
    protected function addphoto(string $photoField,$array){
        array_push($array,$array['photoField']=$photoField);
        return $array;
    }
    protected function setSettinngs($name=false){
        if(isset($name)){
            $this->set=$name;
            return $this->settings[$name];
        }else{
            return $this->settings;
        }
    }
    public function returnSetings(){
        return $this->settings[$this->set];
    }
    public function setValue(string $place,$newvalue){
        if(isset($this->set)){
            $this->settings[$this->set][$place]=$newvalue;
        }else{
            try {
                $error = 'You must use  "get" method to chuse setings which you want to edit  "$this->get($request,$name)" ';
                throw new Exception($error);
            } catch (Exception $e) {
                echo  $e->getMessage();
                die();
            }
        }
    }

}