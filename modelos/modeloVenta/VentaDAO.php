<?php

class VentaDAO extends ConBdMysql{
    function __construct($servidor, $base, $loginBD, $passwordBD) {
        parent::__construct($servidor, $base, $loginBD, $passwordBD);
    }
    
    public function listarVentas(){
        $consulta = "SELECT ventId, ventFecha, ventTotal FROM venta";
        
        $ventas = $this->conexion->prepare($consulta);
        $ventas->execute();
        
        $listadoVenta = array();
        
        while($registro = $ventas->fetch(PDO::FETCH_OBJ)){
            $listadoVenta[] = $registro;
        }
        
        $this->cierreBd();
        return $listadoVenta;
    }
    
    public function ventaPorId($sId = array()){
        $consulta = "SELECT * FROM venta WHERE ventId = ?; ";
        
        $venta = $this->conexion->prepare($consulta);
        $venta->execute(array($sId[0]));
        
        $registroEncontrado = array();
        
        $this->cierreBd();
        
        if(!empty($registroEncontrado)){
            return ['exitoSeleccionId' => TRUE, 'registroEncontrado' => $registroEncontrado];
        }
        else{
            return ['exitoSeleccionId' => FALSE , 'registroEncontrado' => $registroEncontrado];
        }
    }  
}

