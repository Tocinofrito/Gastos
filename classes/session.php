<?php

    class Session
    {
        private $sessionName= 'user';

        public function __construct(){
            if(session_status() == PHP_SESSION_NONE){
                session_start();
            }
        }
    }
    

?>