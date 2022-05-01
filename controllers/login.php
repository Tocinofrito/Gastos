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
                $this->initialize($user);
            }else{
                $this->redirect('', ['error' => ErrorMessages::ERROR_LOGIN_AUTHENTICATE_DATA]);
            }
        }else{
            $this->redirect('',['error' => ErrorMessages::ERROR_LOGIN_AUTHENTICATE]);
        }

    }
}