<?php

class Dashboard extends SessionController{

    function __construct(){
        parent::__construct();
        error_log('Dasboard::construct -> inicio de Login');
    }
    //Funcion que llama a la vista dependiendo el controlador
    function render(){
        error_log('Dasboard::render -> Carga index Dashboard');

        $this->view->render('dashboard/index');
    }
    
    public function getExpenses(){

    }

    public function getCategories(){      

    }

    

}