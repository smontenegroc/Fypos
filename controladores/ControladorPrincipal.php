<?php

include_once PATH . 'controladores/ProductoControlador.php';

class ControladorPrincipal{
    private $datos = array();
    
    public function __construct() {
        if(!empty($_POST) && isset($_POST["ruta"])){
            $this->datos = $_POST;
        }
        if(!empty($_GET) && isset($_GET['ruta'])){
            $this->datos = $_GET;
        }
        
        $this->control();
    }
    
    public function control() {
        
    }
}
