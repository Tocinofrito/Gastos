<?php
class Controller{

    function __construct(){
        $this->view = new View();   
    }
    
    //Carga el modelo recibiendo el
    function loadModel($model){
        $url = 'models/' . $model . 'model.php';
        //Si existe el archivo lo llamamos y podemos cargar el modelo
        if(file_exists($url)){
            require_once $url;
            //Declaramos el nombre del modelo y lo llamamos
            $modelName = $model.'Model';
            $this->model = new $modelName();
        }
    }

    //Permitirá que al recibir parámetros para la bd en vez de poner el isset post y así simplificará eso mismo:
        //$params será un arreglo, si un parametro no existe lo rechaza
    function existPost($params){
        foreach($params as $param) {
            if(!isset($_POST[$param])){
                error_log('CONTROLLER::existPost -> No existe el parámetro ' . $param);
                return false;
            }
        }
        return true;
    }


    function existGet($params){
        foreach($params as $param) {
            if(!isset($_GET[$param])){
                error_log('CONTROLLER::existGet -> No existe el parámetro ' . $param);
                return false;
            }
        }
        return true;
    }

    function getGet($name){
        return $_GET[$name];
    }

    function getPost($name){
        return $_POST[$name];
    }
    
    //Cuando se termina un proceso que se redirija a una pag
    //Debe ser vacío  si quiere mandar a index,  si manda una $route y no  existe manda a 404
    function redirect($route, $mensajes){

        $data = [];
        $params = '';

        foreach($mensajes as $key => $mensaje){
            array_push($data, $key . '=' . $mensaje);
        }
        //Une los elementos dee un arreglo con un caracter
        //Ejemplo hola&adios
        $params = join('&', $data);
        // ?nombre=Marcos&apellido=Rivas
        if($params != ''){
            $params = '?' . $params;
        }
        header('Location: ' . constant('URL') . "/" . $route . $params);
    }

}