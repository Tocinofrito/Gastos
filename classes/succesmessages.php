<?php

class SuccessMessages{

    const PRUEBAS = "278ac1ef34d5efb05f9f7d2c2ff26e62";

    private $successList = [];

    public function __construct() {
        $this->successList = [
            SuccessMessages::PRUEBAS => "ESTE ES UN MENSAJE DE EEXITO"
        ];
    }

    public function get($hash){

        return $this->successList[$hash];
    }

    public function existsKey($key){
        if(array_key_exists($key, $this->successList)){
            return true;
        }else{
            return false;
        }
    }
}