<?php
namespace App\Services\Settings;
use  App\Services\Settings\abstractNavigationSettings;
use Symfony\Component\Config\Definition\Exception\Exception;
class starsSettings extends abstractNavigationSettings{
    public function get($request=false,$name=false){
        $this->settings=[
            'create'=>
                $this->createwithphoto($request,'main','Create Movie')
            ,
            'delete'=>
                $this->delete()
            ,
            'edit'=>
                $this->editwithphoto($request,'Edit Movie')
            ,
            'reed'=>
                $this->reed($request)
            ,

        ];
        return $this->setSettinngs($name);
    }
    function twingreedshema(){
        return [
            'photourl'    =>'stars',
            'title'       =>'Edit Series',
            'sectionName' =>'Stars',
            'editLink'    =>'editStars',
            'deleteLink'  =>'deleteStar',
            'url'         =>'show_movies_with_star',
        ];
    }
}