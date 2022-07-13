<?php

class View{
    function __construct() {
        
    }

    function render($nombre, $data = []){
        $this->d = $data;
        //Manejaremos los mensajes si vieenen por parámetro
        $this->handleMessages();
        error_log('views/' . $nombre . 'php');
        require 'views/' . $nombre . '.php';
        
    }

    //Comprobamos si existe algún error o succes
    private function handleMessages() {

        if(isset($_GET['success']) && isset($_GET['error'])){
            //error
        }else if(isset($_GET['success'])){
            $this->handleSuccess();
        }else if(isset($_GET['error'])){
            $this->handleError();
        }
    }
    
    //Si existe error lo asignamos a d
    private function handleError() {
        $hash = $_GET['error'];
        $error = new ErrorMessages();

        if($error->existsKey($hash)){
            $this->d['error'] = $error->get($hash);
        }
    }
    
    //Si existe succes lo asignamos a d
    private function handleSuccess() {
        $hash = $_GET['success'];
        $success = new SuccessMessages();

        if($success->existsKey($hash)){
            $this->d['success'] = $success->get($hash);
        }
    }

    public function showMessages(){

        $this->showError();
        $this->showSuccess();

    }

    public function showError(){
        if(array_key_exists('error', $this->d)){
            echo '<div class="error">'.$this->d['error'].'</div>';
        }
    }

    public function showSuccess(){
        if(array_key_exists('success', $this->d)){
            echo '<div class="success">'.$this->d['success'].'</div>';
        }
    }
}