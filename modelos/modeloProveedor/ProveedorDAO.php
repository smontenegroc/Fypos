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
    
    //Método para insertar un  nuevo proveedor.
    
    public function insertarProveedor($registro){
        try {
            $query = "INSERT INTO proveedor ";
            $query .= "(provNombre, provTelefono, provDireccion, provMail) ";
            $query .= "VALUES ";
            $query .= "(:provNombre, :provTelefono, :provDireccion, :provMail)";
            
            $inserta = $this->conexion->prepare($query);
            $inserta->bindParam(":provNombre",$registro['provNombre']);
            $inserta->bindParam(":provTelefono",$registro['provTelefono']);
            $inserta->bindParam(":provDireccion",$registro['provDireccion']);
            $inserta->bindParam(":provMail",$registro['provMail']);
            $insercion = $inserta->execute();
            $clavePrimariaConQueInserto = $this->conexion->lastInsertId();
            return ['inserto' => 1,'resultado' => $clavePrimariaConQueInserto];
            
        } catch (Exception $pdoExc) {
            return ['insert' => 0, 'resultado' =>$pdoExc];
        }
    }
    
    public function actualizarProveedor($registro){
        try {
            $provId = $registro['provId'];
            $provNombre = $registro['provNombre'];
            $provTelefono = $registro['provTelefono'];
            $provDireccion = $registro['provDireccion'];
            $provMail = $registro['provMail'];
            
            if(isset($provId)){
                $actualizar = "UPDATE proveedor SET provNombre=?,provTelefono=?,provDireccion=?,provMail=? WHERE provId=?;";
                $actualizacion = $this->conexion->prepare($actualizar);
                $actualizacion = $actualizacion->execute(array($provNombre,$provTelefono,$provDireccion,$provMail,$provId));
                return['actualización' => $actualizacion, 'mensaje' => "Actualización realizada"];
            }
            
        } catch (PDOException $pdoExc) { 
            $err = ['mensaje' =>$pdoExc];
            return ("Error al actualizar " . $err['mensaje']);
        }
    }
    
    public function eliminadoFisicoProveedor($sId=array()) {
        $consulta = "DELETE FROM proveedor";
        $consulta .= " WHERE provId= :provId;";
        $eliminar = $this->conexion->prepare($consulta);
        $eliminar->bindParam(':provId',$sId[0], PDO::PARAM_INT);
        $eliminar->execute();
        
        $this->cierreBd();
        
        if(!empty($resultado)){
            return ['eliminar' => TRUE, 'registroEliminado' => array($sId[0])];
        }
        else{
            return ['eliminar' => FALSE, 'registroEliminado' => array($sId[0])];
        }
    }
    
    public function eliminadoLogicoProveedor($sId=array()) {
        try {
            $cambiarEstado = 0;
            if(isset($sId[0])){
                $eliminarLogico = "UPDATE proveedor SET provEstado=? WHERE provId=?;";
                $eliminacionLogica = $this->conexion->prepare($eliminarLogico);
                $eliminacionLogica = $eliminacionLogica->execute(array($cambiarEstado,$sId[0]));
                return ['Eliminado' => $eliminacionLogica, 'Mensaje' => 'Registro ináctivo'];
            }
        } catch (PDOException $pdoExc) {
            return ['Mensaje' => $pdoExc];
        }
    }
}
