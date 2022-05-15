<?php
require_once 'models/usermodel.php';

class LoginModel extends Model{
    
    function __construct(){
        parent::__construct();
        
    }

    function login($username, $password){
        try {
            //Accedemos  a dbname
            
            $query = $this->prepare('SELECT * FROM users WHERE username = :username');
            $query->execute(['username' => $username]);
            //Si existe usuario con el username accedemos a los datos de la
            //Como no puede haber más de 1 usuario con el mismo nombre pos hacemos la pregunta si existe 1
            if($query->rowCount() == 1){

                $item = $query->fetch(PDO::FETCH_ASSOC);

                $user = new UserModel();
                //from inicializa el userModel con los datos enviados, en este caso los que mandamos de la anteior consulta del login
                $user->from($item);
                if(password_verify($password, $user->getPassword())){
                    error_log('LoginModel::login->success');
                    return $user;
                }else {
                    error_log('LoginModel::login->PASSWORD NO ES IGUAL');
                    return NULL;
                }
                
            }
            
        } catch (PDOException $e) {
            error_log('LoginModel::login -> exception' . $e);
            return NULL;
        }
    }

}