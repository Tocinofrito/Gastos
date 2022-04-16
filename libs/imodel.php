<?php
//Permite definir métodos a ser implementados
//Aqui no va lógica, solo los métodos con sus parámetros
interface IModel{
    public function save();
    public function getAll();
    public function get($id);
    public function delete($id);
    public function update();
    public function from($array);
}