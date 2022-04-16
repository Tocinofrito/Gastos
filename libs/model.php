<?php
include_once 'libs/imodel.php';
class Model{

    function __construct(){
        //No importamos tal cual el archvo db
        $this->db = new Database();

    }

    function query($query){
        return $this->db->connect()->query($query);
    }

    function prepare($query){
        return $this->db->connect()->prepare($query);
    }
}