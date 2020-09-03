<?php

class CompraDAO extends ConBdMysql{
    public function __construct($servidor, $base, $loginBD, $passwordBD) {
        parent::__construct($servidor, $base, $loginBD, $passwordBD);
    }
    
    public function listarCompras() {
        $consulta = "SELECT comId, comFecha, comCantidad, comCostoUnitario, comPagar FROM compra;";
        $compras = $this->conexion->prepare($consulta);
        $compras->execute();
        
        $listadoCompras = array();
        
        while($registro = $compras->fetch(PDO::FETCH_OBJ)){
            $listadoCompras[] = $registro;
        }
        $this->cierreBd();
        return $listadoCompras;
    }
    
    public function compraPorId($sId = array()){
        $consulta = "SELECT * FROM compra WHERE comId = ?;";
        $compra = $this->conexion->prepare($consulta);
        $compra->execute(array($sId[0]));
        
        $registroEncontrado = array();
        
        $this->cierreBd();
        
        if(!empty($registroEncontrado)){
            return ['exitoSeleccionId' => TRUE, 'registroEncontrado' => $registroEncontrado];
        }
        else{
            return ['exitoSeleccionId' => FALSE , 'registroEncontrado' => $registroEncontrado];
        }
    }
    
    public function insertarCompra ($registro){
        try {
            $consulta = "INSERT INTO compra "
                    . "(comCantidad, comCostoUnitario,comPagar) "
                    . "VALUES (:comCantidad,:comCostoUnitario,:comPagar)";
            
            $inserta = $this->conexion->prepare($consulta);
            $inserta->bindParam(":comCantidad",$registro['comCantidad']);
            $inserta->bindParam(":comCostoUnitario",$registro['comCostoUnitario']);
            $inserta->bindParam(":comPagar",$registro['comPagar']);
            $insercion = $inserta->execute(); 
            $clavePrimariaConQueInserto = $this->conexion->lastInsertId();
            
            return ['inserto' => 1,'resultado' => $clavePrimariaConQueInserto];
            
        } catch (PDOException $pdoExc) {
            return ['insert' => 0, 'resultado' =>$pdoExc];
        }
    }
    
}

