<?php

class ProveedorDAO extends ConBdMysql{
    
    //Constructor de la clase.
    function __construct($servidor, $base, $loginBD, $passwordBD) {
        parent::__construct($servidor, $base, $loginBD, $passwordBD);
    }
    
    //Método de listar proveedores
    
    public function listarProveedores(){
        
        $consulta = "SELECT provId, provNombre, provTelefono, provDireccion, provMail FROM proveedor";
        
        $proveedores = $this->conexion->prepare($consulta);
        $proveedores->execute();
        
        $listadoProveedores = Array();
        
        while ($registro = $proveedores->fetch(PDO::FETCH_OBJ)){
            $listadoProveedores[] = $registro;
        }
        
        $this->cierreBd();
        return $listadoProveedores;        
    }
    
    //Método para consultar un proveedor por su ID.
    
    public function proveedorPorId($sId = array()) {
        
        $consulta = "SELECT * FROM proveedor WHERE provId= ? ;";
        
        $proveedor = $this->conexion->prepare($consulta);
        $proveedor->execute(array($sId[0]));
        
        $registroEncontrado = array();
        
        while($registro = $proveedor->fetch(PDO::FETCH_OBJ)){
            $registroEncontrado[] = $registro; 
        }
        $this->cierreBd();
        if(!empty($registroEncontrado)){
            return ['exitoSeleccionId' => TRUE , 'registroEncontrado' => $registroEncontrado];
        }
        else{
            return ['exitoSeleccionId' => FALSE , 'registroEncontrado' => $registroEncontrado];
        }
    }
}
