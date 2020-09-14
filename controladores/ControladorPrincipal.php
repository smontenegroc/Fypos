<?php

include_once 'ProductoControlador.php';
include_once 'ProveedoresControlador.php';


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
        switch ($this->datos['ruta']){
            case 'listarProductos':
                $productoControlador = new ProductoControlador($this->datos);
                break;
            case 'actualizarProducto':   
                $productoControlador = new ProductoControlador($this->datos);
                break;
            case 'eliminarProducto':
                $productoControlador = new ProductoControlador($this->datos);
                break;
            case 'confirmaActualizarProducto':
                $productoControlador = new ProductoControlador($this->datos);
                break;
            case 'mostrarInsertarProducto':
                $productoControlador = new ProductoControlador($this->datos);
                break;
            case 'insertarProducto':
                $productoControlador = new ProductoControlador($this->datos);
                break;
            case 'listarProveedores':
                $proveedorControlador = new ProveedoresControlador($this->datos);
                break;
        }
        
    }
}
