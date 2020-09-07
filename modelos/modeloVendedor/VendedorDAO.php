<?php

class VendedorDAO extends ConBdMysql{
    function __construct($servidor, $base, $loginBD, $passwordBD) {
        parent::__construct($servidor, $base, $loginBD, $passwordBD);
    }
    
    public function listarVendedores(){
        $consulta = "SELECT venId, venDocumento, venNombre, venApellido FROM vendedores";
        
        $vendedores = $this->conexion->prepare($consulta);
        $vendedores->execute();
        
        $listadoVendedores = array();
        
        while($registro = $vendedores->fetch(PDO::FETCH_OBJ)){
            $listadoVendedores[] = $registro;
        }
        
        $this->cierreBd();
        return $listadoVendedores;
    }
    
    public function vendedorPorId($sId = array()){
        $consulta = "SELECT * FROM vendedores WHERE venId=? ;";
        
        $proveedor = $this->conexion->prepare($consulta);
        $proveedor->execute(array($sId[0]));
        
        $registroEncontrado = array();
        
        while($registro = $proveedor->fecth(PDO::FETCH_OBJ)){
            $registroEncontrado[] = $registro;
        }
        
        $this->cierreBd();
        if(!empty($registroEncontrado)){
            return ['exitoSeleccionId' => TRUE, 'registroEncontrado' => $registroEncontrado];
        }
        else{
            return ['exitoSeleccionId' => FALSE , 'registroEncontrado' => $registroEncontrado];
        }
    }
    
    public function insertarVendedor($registro){       
        
        try {
            $query = "INSERT INTO vendedores ";
            $query .= "(venDocumento,venNombre,venApellido )";
            $query .= "VALUES ";
            $query .= "(:venDocumento,:venNombre,:venApellido)";
            
            $inserta = $this->conexion->prepare($query);
            $inserta->bindParam(":venDocumento",$registro['venDocumento']);
            $inserta->bindParam(":venNombre",$registro['venNombre']);
            $inserta->bindParam(":venApellido",$registro['venApellido']);
            $insercion = $inserta->execute();
            $clavePrimariaConQueInserto = $this->conexion->lastInsertId();
            return ['inserto' => 1,'resultado' => $clavePrimariaConQueInserto];
            
            
        } catch (Exception $pdoExc) {
            return ['insert' => 0, 'resultado' =>$pdoExc];
        }
    }

    public function actualizarVendedor($registro){
        try{
            $venId = $registro['venId'];
//            $venDocumento = $registro['venDocumento'];
            $venNombre = $registro['venNombre'];
            $venApellido = $registro['venApellido'];
            
            if(isset($venId)){
                $actualizar = "UPDATE vendedores SET venNombre=?,venApellido=? WHERE venId=?";
                $actualizacion = $this->conexion->prepare($actualizar);
                $actualizacion = $actualizacion->execute(array($venNombre,$venApellido,$venId));
                return['actualización' => $actualizacion, 'mensaje' => "Actualización realizada"];
            }
            
        } catch (PDOException $pdoExc) {
            $err = ['mensaje' =>$pdoExc];
            return ("Error al actualizar " . $err['mensaje']);
        }
    }
    
    public function eliminadoFisicoVendedor($sId=array()){
        $consulta = "DELETE FROM vendedores "
                . "WHERE venId= :venId;";
        
        $eliminar = $this->conexion->prepare($consulta);
        $eliminar->bindParam(':venId',$sId[0], PDO::PARAM_INT);
        $eliminar->execute();
        $this->cierreBd();
        
        if(!empty($resultado)){
            return ['eliminar' => TRUE, 'registroEliminado' => array($sId[0])];
        }
        else{
            return ['eliminar' => FALSE, 'registroEliminado' => array($sId[0])];
        }
    }
    
    public function eliminadoLogicoVendedor($sId=array()) {
        try {
            $cambiarEstado = 0;
            if(isset($sId[0])){
                $eliminarLogico = "UPDATE vendedores SET venEstado=? WHERE venId=?;";
                $eliminacionLogica = $this->conexion->prepare($eliminarLogico);
                $eliminacionLogica = $eliminacionLogica->execute(array($cambiarEstado,$sId[0]));
                return ['Eliminado' => $eliminacionLogica, 'Mensaje' => 'Registro ináctivo'];
            }
        } catch (PDOException $pdoExc) {
            return ['Mensaje' => $pdoExc];
        }
    }
}

