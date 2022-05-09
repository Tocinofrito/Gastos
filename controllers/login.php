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
    
    function authenticate(){

        if($this->existPOST(['username', 'password'])){
            $username = $this->getPost('username');
            $password = $this->getPost('password');

            if($username == '' || empty($username) || $password == '' || empty($password)){
                error_log('Login::authenticate()');
                $this->redirect('', ['error' => Errors::ERROR_LOGIN_AUTHENTICATE_EMPTY]);
                return;
            }
            $user = $this->model->login($username, $password);
            if($user != NULL){
                //Si existe el usuario y logea correctamente inicializamos con los datos la sesion y redirigimos a su pagina default

                $this->initialize($user);
            }else{
                //Si no redirigimos a pagina principal con el error 
                $this->redirect('', ['error' => ErrorMessages::ERROR_LOGIN_AUTHENTICATE_DATA]);
            }
        }else{
            //Si no logea bien error de autenticación
            $this->redirect('',['error' => ErrorMessages::ERROR_LOGIN_AUTHENTICATE]);
        }

    }
}