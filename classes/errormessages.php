<?php

class ErrorMessages{
        //ERROR_CONTROLLER_METHOD_ACTION
    const ERROR_ADMIN_NEWCATEGORY_EXISTS = "278ac1ef34d5efb05f9f7d2c2ff26e62";
    const ERROR_SIGNUP_NEWUSER ="278ac1ef34d53fa25f9f7d2c2ff26e62";
    const ERROR_SIGNUP_NEWUSER_EMPTY = "223ac1ef34d53fa25g9f7d3c2ae26e62";
    const ERROR_SIGNUP_NEWUSER_EXISTS = "223ac1ef34d53fa25g9f7d3c2gf26a61";
    const ERROR_LOGIN_AUTHENTICATE_EMPTY = "hgd23v12fc12v3ogho12ov123vm812fhc4129m8h";
    const ERROR_LOGIN_AUTHENTICATE_DATA ="278ac1ef34d5efb05f9f7d2c2ff26easdf2";
    private $errorList = [];

    public function __construct() {
        $this->errorList = [
            ErrorMessages::ERROR_ADMIN_NEWCATEGORY_EXISTS => 'El nombre de la categoría ya existe',
            ErrorMessages::ERROR_SIGNUP_NEWUSER => 'Hubo un error al intentar procesar la solicitud',
            ErrorMessages::ERROR_SIGNUP_NEWUSER_EMPTY => 'Llena los campos de usuario y contraseña',
            ErrorMessages::ERROR_SIGNUP_NEWUSER_EXISTS => 'El nombre de usuario ya existe, escoge otro',
            ErrorMessages::ERROR_LOGIN_AUTHENTICATE_EMPTY => 'Llena los campos de usuario y contraseña',
            ErrorMessages::ERROR_LOGIN_AUTHENTICATE_DATA => 'Nombre de usuario y/o contraseña incorrectos',
            ErrorMessages::ERROR_LOGIN_AUTHENTICATE => 'No se puede procesar la solicitud ingrese  usuario y password'

        ];    
    }

    public function get($hash){

        return $this->errorList[$hash];
    }

    public function existsKey($key){
        if(array_key_exists($key, $this->errorList)){
            return true;
        }else{
            return false;
        }
    }
}