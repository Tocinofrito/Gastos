<?php

class LoginModel extends Model{
    
    function __construct(){
        parent::__construct();
        
    }

    function login($username, $password){
        try {
            //Accedemos  a dbname
            $query = $this->prepare('SELECT FROM users WHERE username = : username');
            $query->execute(['username' => $username]);
            if($query-rowCount() == 1){
                
            }
            
        } catch (PDOException $e) {
            error_log('LoginModel::login -> exception' . $e);
            return NULL;
        }
    }

}