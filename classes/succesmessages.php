<?php

class SuccessMessages{

    const PRUEBAS = "278ac1ef34d5efb05f9f7d2c2ff26e62";
    const SUCCES_SIGNUP_NEWUSER = "278ac1jf33n5efh0519f7d2f2ff26a62";

    private $successList = [];

    public function __construct() {
        $this->successList = [
            SuccessMessages::PRUEBAS => "ESTE ES UN MENSAJE DE EXITO",
            SuccessMessages::SUCCES_SIGNUP_NEWUSER => "Nuevo usuario registrado correctamente"
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