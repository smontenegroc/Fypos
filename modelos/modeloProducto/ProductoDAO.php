<?php
include_once PATH .'modelos/ConBdMysql.php';

class ProductoDAO extends ConBdMysql{
    
    function __construct($servidor, $base, $loginBD, $passwordBD) {
        parent::__construct($servidor, $base, $loginBD, $passwordBD);
    }
    
    public function listarProductos(){
        $consulta = "SELECT pr.proId, pr.proNombre, pr.proDescripcion,pr.proPrecio, pr.proCantidad, pv.provNombre ";
        $consulta .="FROM  producto AS pr JOIN proveedor  AS pv ON pr.provId = pv.provId  WHERE pr.proEstado = 1";
        $productos = $this->conexion->prepare($consulta);
        $productos->execute();
        
        $listadoProductos = array();
        
        while($registro = $productos->fetch(PDO::FETCH_OBJ)){
            $listadoProductos[] = $registro;
        }
        
        $this->cierreBd();
        return $listadoProductos;
    }
    
    public function productoPorId($sId){
        $consulta = "SELECT pr.proId, pr.proNombre, pr.proDescripcion, pr.proPrecio, pr.proCantidad, pv.provNombre"
                . " FROM producto AS pr  JOIN proveedor AS pv ON pr.provId = pv.provId WHERE pr.proId= ? ;";        
        $producto = $this->conexion->prepare($consulta);
        $producto->execute(array($sId));
        
        $registroEncontrado = array();
        
        while($registro = $producto->fetch(PDO::FETCH_OBJ)){
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
    
    public function insertarProducto($registro){
        try {
            $query = "INSERT INTO producto";
            $query .= " (proNombre,proDescripcion,proPrecio,proCantidad,provId)";
            $query .= " VALUES ( :proNombre, :proDescripcion, :proPrecio; :proCantidad, :provId)";
            
            $inserta = $this->conexion->prepare($query);
            $inserta->bindParam(":proNombre",$registro['proNombre']);
            $inserta->bindParam(":proDescripcion",$registro['proDescripcion']);
            $inserta->bindParam(":proPrecio",$registro['proPrecio']);
            $inserta->bindParam(":proCantidad",$registro['proCantidad']);
            $inserta->bindParam(":provId",$registro['provId']);
            $insercion = $inserta->execute(); 
            $clavePrimariaConQueInserto = $this->conexion->lastInsertId();
            return ['inserto' => 1,'resultado' => $clavePrimariaConQueInserto];
            
        } catch (PDOException $pdoExc) {
            return ['insert' => 0, 'resultado' =>$pdoExc];
        }
    }
    
    public function actualizarProducto($registro){        
        try {
          $proId = $registro['proId'];
          $proNombre = $registro['proNombre'];
          $proDescripcion = $registro['proDescripcion'];
          $proPrecio = $registro['proPrecio'];
          $proCantidad = $registro['proCantidad'];
          $proveedor = $registro['proveedores'];          
          if(isset($proId)){
            $actualizar = "UPDATE producto SET proNombre=?, proDescripcion=?, proPrecio=?, proCantidad=?, provId=? WHERE proId=?;";
            $actualizacion = $this->conexion->prepare($actualizar);
            $actualizacion = $actualizacion->execute(array($proNombre,$proDescripcion,$proPrecio,$proCantidad,$proveedor,$proId));
            return['actualización' => $actualizacion, 'mensaje' => "Actualización realizada"];
          }
        } catch (PDOException $pdoExc) {
            $err = ['mensaje' =>$pdoExc];
            return ("Error al actualizar " . $err['mensaje']);
        }
    }
    
    public function eliminadoFisicoProducto($sId=array()){
        $qeliminar = "DELETE FROM producto ";
        $qeliminar .= "WHERE proId= :proId ;";
        $eliminar = $this->conexion->prepare($qeliminar);
        $eliminar->bindParam(':proId', $sId[0], PDO::PARAM_INT);
        $eliminar->execute();
        $this->cierreBd();
        
        if(!empty($resultado)){
            return ['eliminar' => TRUE, 'registroEliminado' => array($sId[0])];;
        }
        else{
            return ['eliminar' => FALSE, 'registroEliminado' => array($sId[0])];
        }
    }
    
    public function eliminadoLogicoProducto($sId) {
        try {
            $cambiarEstado = 0;
            if(isset($sId)){
                $eliminarLogico = "UPDATE producto SET proEstado=? WHERE proId=?;";
                $eliminacionLogica = $this->conexion->prepare($eliminarLogico);
                $eliminacionLogica = $eliminacionLogica->execute(array($cambiarEstado,$sId));
                return ['Eliminado' => $eliminacionLogica, 'Mensaje' => 'Registro ináctivo'];
            }
        } catch (PDOException $pdoExc) {
            return ['Mensaje' => $pdoExc];
        }
    }
}
