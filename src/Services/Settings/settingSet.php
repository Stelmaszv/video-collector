<?php
namespace App\Services\Settings;
class settingSet{
    private $settings;
    public function set(object $setings){
        return $this->settings=$setings;
    }
}