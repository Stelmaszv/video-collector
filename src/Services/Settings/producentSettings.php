<?php
namespace App\Services\Settings;
use  App\Services\Settings\abstractNavigationSettings;
use Symfony\Component\Config\Definition\Exception\Exception;
class producentSettings extends abstractNavigationSettings{
    public function get($request=false,$name=false){
        $array=$this->create($request,'showProducents','Create Producent');
        $this->settings=[
            'create'=>
                $this->addphoto('avatar',$array)
            ,
            'delete'=>
                $this->delete()
            ,
            'edit'=>
                $this->edit($request,'Edit Producent')
            ,
            'reed'=>
                $this->reed($request)
            ,
        ];
        return $this->setSettinngs($name);
    }
    function twingreedshema(){
        return [
            'photourl'             =>'producent',
            'sectionName'          =>'Producent',
            'editLink'             =>'editProducent',
            'deleteLink'           =>'deleteProducents',
            'url'                  =>'show_series_in_producent',
        ];
    }
}