<?php
namespace App\Services\Settings;
use  App\Services\Settings\abstractNavigationSettings;
use Symfony\Component\Config\Definition\Exception\Exception;
class tagsSettings extends abstractNavigationSettings{
    public function get($request=false,$name=false){
        $this->settings=[
            'create'=>
                $this->createwithphoto($request,'main','Create Category')
            ,
            'delete'=>
                $this->delete()
            ,
            'edit'  =>
               $this->editwithphoto($request,'main','Create Category')
            ,
            'reed'=>
                $this->reed($request)
            ,

        ];
        return $this->setSettinngs($name);
    }
    function twingreedshema(){
        return [
            'photourl'             =>'series',
            'sectionName'          =>'Categoy',
            'editLink'             =>'editCategory',
            'deleteLink'           =>'deleteTag',
            'url'                  =>'show_movies_in_category',
        ];
    }
}