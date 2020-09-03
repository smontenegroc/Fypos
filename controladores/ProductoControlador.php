<?php

include_once PATH.'modelos/modeloProducto/ProductoDAO.php';

class ProductoControlador{
    private $datos;
    
    public function __construct($datos) {
        $this->datos = $datos;
    }
}

