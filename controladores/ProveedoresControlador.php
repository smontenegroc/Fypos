<?php

include_once PATH .'/modelos/modeloProveedor/ProveedorDAO.php';

class ProveedoresControlador {
    private $datos;
    
    public function __construct($datos) {
        $this->datos = $datos;
        $this->ProveedoresControlador();
    }
    
    public function ProveedoresControlador(){
        switch ($this->datos['ruta']){
            case 'listarProveedores':
                $gestarProveedores = new ProveedorDAO(SERVIDOR, BASE, USUARIO_DB, CONTRESENIA_DB);
                $registroProveedores = $gestarProveedores->listarProveedores();
                session_start();
                $_SESSION['listaDeProveedores'] = $registroProveedores;
                header('location:principal.php?contenido=vistas/vistasProducto/listarProductos.php');
                break;
        }
    }
}

