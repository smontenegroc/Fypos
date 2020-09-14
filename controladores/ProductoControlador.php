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
                header('location:principal.php?contenido=vistas/vistasProveedores/listarProveedores.php');
                break;
        
            case 'actualizarProducto':
                $gestarProducto = new ProductoDAO(SERVIDOR, BASE, USUARIO_DB, CONTRESENIA_DB);
 
                $consultaDeProducto =  $gestarProducto->productoPorId($this->datos['idAct']);                
                $actualizarDatosProducto = $consultaDeProducto['registroEncontrado'][0];
                
                $gestarProveedor = new ProveedorDAO(SERVIDOR, BASE, USUARIO_DB, CONTRESENIA_DB);
                $registroProveedor = $gestarProveedor->listarProveedores();
                
                session_start();
                $_SESSION['actualizarDatosProducto'] = $actualizarDatosProducto;
                $_SESSION['registroProveedor'] = $registroProveedor;
                
                header('location:principal.php?contenido=vistas/vistasProducto/actualizarProducto.php');
                break;
            case 'eliminarProducto':
                $gestarProducto = new ProductoDAO(SERVIDOR, BASE, USUARIO_DB, CONTRESENIA_DB);
                $gestarProducto->eliminadoLogicoProducto($this->datos['idEli']);
                session_start();
                $_SESSION['mensaje'] = "Borrado exitoso!";
                header('location:Controlador.php?ruta=listarProductos');
                break;
            case 'confirmaActualizarProducto':
                $gestarProducto = new ProductoDAO(SERVIDOR, BASE, USUARIO_DB, CONTRESENIA_DB);
                $actualizarProducto = $gestarProducto->actualizarProducto($this->datos);
                session_start();
                $_SESSION['mensaje'] = 'Datos actualizados';
                header('location:Controlador.php?ruta=listarProductos');
                break;
            case 'mostrarInsertarProducto':
                $gestarProveedor = new ProveedorDAO(SERVIDOR, BASE, USUARIO_DB, CONTRESENIA_DB);
                $registroProveedor = $gestarProveedor->listarProveedores();
                session_start();
                $_SESSION['registroProveedor'] = $registroProveedor;
                header('location:principal.php?contenido=vistas/vistasProducto/insertarProducto.php');
                break;
            case 'insertarProducto':
//                $buscarProducto = new ProductoDAO(SERVIDOR,BASE,USUARIO_DB,CONTRESENIA_DB);
//                $productoHallado = $buscarProducto->productoPorId($this->datos);
                $insertarProducto = new ProductoDAO(SERVIDOR, BASE, USUARIO_DB, CONTRESENIA_DB);
                $insertoProducto = $insertarProducto->insertarProducto($this->datos);
                $exitoInsercionproducto = $insertoProducto['inserto'];
                $resultadoInsercionProducto = $insertoProducto['resultado'];
                session_start();
                $_SESSION['mensaje'] = "Registrado ".$this->datos['proNombre']. " con éxito. Producto agregado " . $resultadoInsercionProducto;
                header('location:Controlador.php?ruta=listarProductos');
                break;            
        }
    }
}

