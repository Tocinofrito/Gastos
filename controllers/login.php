<?php

class Login extends SessionController{

    function __construct(){
        parent::__construct();
        error_log('Login::construct -> inicio de Login');
    }
    //Funcion que llama a la vista dependiendo el controlador
    function render(){
        error_log('Login::render -> Carga index login');

        $this->view->render('login/index');
    }
}