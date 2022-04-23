<?php

class Signup extends SessionController{

    function __construct(){
        parent::__construct();

    }

    function render(){
        $this->view->render('login/signup', []);
    }

    function newUser(){
        if($this->existPOST(['username','password'])){
            $this->getPost('username');
            $this->getPost('password');

            if($username == '' || empty($username) || empty($password) || $password == ''){
                $this->redirect('signup',['error' =>ErrorMessages::ERROR_SIGNUP_NEWUSER_EMPTY] );
            }
            $user = new UserModel();
            $user->setUsername($username);
            $user->setPassword($password);
            $user->setRole('user');
            if($user->exists($username)) {
                $this->redirect('signup',['error' =>ErrorMessages::ERROR_SIGNUP_NEWUSER_EXISTS] );
            }else if($user->save()){
                $this->redirect('success',['error' =>ErrorMessages::SUCCES_SIGNUP_NEWUSER]);
            }else {
                $this->redirect('error',['error' =>ErrorMessages::ERROR_SIGNUP_NEWUSER]);
            }
        }else{
            $this->redirect('signup', ['error' =>ErrorMessages::ERROR_SIGNUP_NEWUSER ]);
        }
    }

}



?>