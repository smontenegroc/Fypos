    <?php

class ProductoDAO extends ConBdMysql{
    
    function __construct($servidor, $base, $loginBD, $passwordBD) {
        parent::__construct($servidor, $base, $loginBD, $passwordBD);
    }
    
    public function listarProductos(){
        
        $consulta = "SELECT proId,proNombre,proDescripcion,proPrecio,proCantidad FROM producto";
        
        $productos = $this->conexion->prepare($consulta);
        $productos->execute();
        
        $listadoProductos = array();
        
        while($registro = $productos->fetch(PDO::FETCH_OBJ)){
            $listadoProductos[] = $registro;
        }
        
        $this->cierreBd();
        return $listadoProductos;
    }
    
    public function productoPorId($sId = array()){
        
        $consulta = "SELECT * FROM producto WHERE proId= ? ;";
        
        $producto = $this->conexion->prepare($consulta);
        $producto->execute(array($sId[0]));
        
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
            $query += " (proNombre,proDescripcion,proPrecio,proCantidad,provId)";
            $query += " VALUES ( :proNombre, :proDescripcion, :proPrecio; :proCantidad, :provId)";
            
            $inserta = $this->conexion->prepare($query);
            $inserta->bindParam(":proNombre",$registro['proNombre']);
            $inserta->bindParam(":proDescripcion",$registro['proDescripcion']);
            $inserta->bindParam(":proPrecio",$registro['proPrecio']);
            $inserta->bindParam(":proCantidad",$registro['proCantidad']);
            $inserta->bindParam(":provId",$registro['provId']);
            $insercion = $inserta->execute(); 
            $clavePrimariaConQueInserto = $this->conexion->lastInsertId();
            return ['inserto' => 1,'resultado' => $clavePrimariaConQueInserto];
            
        } catch (Exception $ex) {
            
        }
    }
}
