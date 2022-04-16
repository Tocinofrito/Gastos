<?php

require_once 'controllers/errores.php';

class App{
    
    function __construct(){
        //Llega como get si hay un parametro en la url por la config .htaccess
        $url = isset($_GET['url']) ? $_GET['url'] : null;
        $url = rtrim($url, '/');
        //var_dump($url);
        //Separa en un array cada fragmento de la url por parentesis
        $url = explode('/', $url);
        //var_dump($url);

        //Queda masomenos así
        //user updatePhoto

        //Si no existee dicho parámetro
        if(empty($url[0])){
            error_log('APP::CONSTRUCT-> no hay controlador especificado');
            //Lo mandamos al login con el controlador
            $archivoController = 'controllers/login.php';
            require_once $archivoController;
            //Creamos instancia del controlador
            $controller = new Login();
            $controller->loadModel('login');
            $controller->render();
            return false;
        }
        //Si existee el parametro
        $archivoController = 'controllers/' . $url[0] . '.php';
        //var_dump($archivoController);
        if(file_exists($archivoController)){
            require_once $archivoController;
            $controller = new $url[0];
            $controller->loadModel($url[0]);
            //Si existe el metodo:
            if(isset($url[1])){
                if(method_exists($controller, $url[1])){
                    //Checamos si hay parametros  para la funcion
                    if(isset($url[2])){
                        //num  de parametros
                        $nparam = count($url) -2; //Si es mayor a 0 hay mas parametros
                        $params = [];
                        for($i = 0; $i<$nparam; $i++){
                            array_push($params, $url[$i] + 2);
                        }
                        $controller->{$url[1]}($params);

                    }else{
                        //No tiene parametros, se  manda al llamar al metodo tal cual
                        $controller->{$url[1]}();
                    }
                }else{
                    //Error, no existe método 
                    $controller = new Errores();
                    $controller->render();
                }
            }else{
                //no hay metodo a cargar, se carga el default
                $controller->render();
                
            } 
        }else{
            //No existe el archivo manda error
            $controller = new Errores();
            $controller->render();
            error_log('El archivo(controlador)no existe');
        }
        
    }
}
