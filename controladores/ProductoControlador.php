<?php

include_once PATH .'/modelos/modeloProducto/ProductoDAO.php';
include_once PATH .'/modelos/modeloProveedor/ProveedorDAO.php';

class ProductoControlador{
    private $datos;
    
    public function __construct($datos) {
        $this->datos = $datos;
        $this->productoControlador();
    }

    public function productoControlador(){
        switch ($this->datos['ruta']){
            case 'listarProductos':
                $gestarProductos = new ProductoDAO(SERVIDOR, BASE, USUARIO_DB, CONTRESENIA_DB);
                $registroProductos = $gestarProductos->listarProductos();
                session_start();
                $_SESSION['listaDeProductos'] = $registroProductos;
                header('location:principal.php?contenido=vistas/vistasProducto/listarProductos.php');
            break;
        
            case 'actualizarProducto':
                $gestarProducto = new ProductoDAO(SERVIDOR, BASE, USUARIO_DB, CONTRESENIA_DB);
                $consultaDeProducto =  $gestarProducto->productoPorId($this->datos['idAct']);
//                echo '<pre>';
//                print_r($consultaDeProducto);
//                echo '</pre>';
//                exit();
                $actualizarDatosProducto = $consultaDeProducto['registroEncontrado'][0];
                
                $gestarProveedor = new ProveedorDAO(SERVIDOR, BASE, USUARIO_DB, CONTRESENIA_DB);
                $registroProveedor = $gestarProveedor->listarProveedores();
                
                session_start();
                $_SESSION['actualizarDatosProducto'] = $actualizarDatosProducto;
                $_SESSION['registroProveedor'] = $registroProveedor;
                
                header('location:principal.php?contenido=vistas/vistasProducto/actualizarProducto.php');
            break;
        }
    }
}

