<?php

    class Session
    {
        private $sessionName= 'user';
        //Inicia la sesión
        public function __construct(){
            if(session_status() == PHP_SESSION_NONE){
                session_start();
            }
        }
        //Crea la sesión user
        public function setCurrentUser($user){
            $_SESSION[$this->sessionName] = $user;


        }
        //Regresa el usuario actual
        public function getCurrentUser(){
            return $SESSION[$this->sessionName];
        }
        //Cierra sesión y la elimina
        public function closeSession(){
            session_unset();
            session_destroy();
        }
        //Retorna si existe la sesión
        public function exists(){
            return isset($_SESSION[$this->sessionName]);

        }
    }
    

?>