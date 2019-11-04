<?php
namespace App\Services\Settings;
use  App\Services\Settings\abstractNavigationSettings;
use Symfony\Component\Config\Definition\Exception\Exception;
class seriesSettings extends abstractNavigationSettings{
    public function get($request=false,$name=false){
        $this->settings=[
            'create'=>
                $this->createwithphoto($request,'main','Create Series')
            ,
            'delete'=>
                $this->delete()
            ,
            'edit'=>
                $this->editwithphoto($request,'Edit Series')
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
            'title'                =>'Edit Series',
            'sectionName'          =>'Series',
            'editLink'             =>'editSeries',
            'deleteLink'           =>'deleteSeries',
            'url'                  =>'show_movies_in_series',
        ];
    }
}