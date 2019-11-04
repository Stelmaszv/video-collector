<?php
namespace App\Services\Settings;
use  App\Services\Settings\abstractNavigationSettings;
use Symfony\Component\Config\Definition\Exception\Exception;
class moviesSettings extends abstractNavigationSettings{
    public function get($request=false,$name=false){
        $this->settings=[
            'create'=>
                $this->create($request,'main','Create Movie')
            ,
            'delete'=>
                $this->delete()
            ,
            'edit'=>
                $this->edit($request,'Edit Movie')
            ,
            'reed'=>
                $this->reed($request)
            ,

        ];
        return $this->setSettinngs($name);
    }
    protected function ncreate($request,$header){
        return $this->$this->create($request,$header);
    }
    public function twingreedshema(){
        return [
            'sectionName'          =>'Movies',
            'editLink'             =>'editMovies',
            'deleteLink'           =>'deleteMovie',
            'url'                  =>'show_movie',
        ];
    }
}