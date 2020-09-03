<?php

class LibroDAO  extends ConBdMysql{
    private $cantidadTotalRegistros;
    
    function construct($servidor,$base,$loginBD,$passwordBD){
        parent::__construct($servidor, $base, $loginBD, $passwordBD);
    }
    
    public function seleccionarTodos(){
        $planConsulta = "select l.isbn,l.titulo,l.autor,l.precio,cl.catLibId,cl.catLibNombre";
        $planConsulta .=" from libros l join categorialibro cl";
        $planConsulta .=" ON l.categoriaLibro_CatLibId = cl.catLibId";
        $planConsulta .=" order by l.isbn ASC";
        
        $registrosLibro = $this->conexion->prepare($planConsulta);
        $registrosLibro->execute();
        
        $listadoRegistrosLibro = array();
        
        while($registro = $registrosLibro->fetch(PDO::FETCH_OBJ)){
            $listadoRegistrosLibro[] = $registro;
        }
        $this->cierreBd();        
        return $listadoRegistrosLibro;
    }
    
    public function seleccionarId($sId = array()){
        
        $planConsulta = "select * from ven l";
        $planConsulta .= " where l.isbn=? ;";
        
        $listar = $this->conexion->prepare($planConsulta);
        $listar->execute(array($sId[0]));
        
        $registroEncontrado = array();
        
        while($registro = $listar->fetch(PDO::FETCH_OBJ)){
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
    
    public function insertar($registro){
        try{
            $query = "INSERT INTO libros";
            $query .= " (isbn,titulo,autor,precio,categoriaLibro_catLibId)";
            $query .= " VALUES";
            $query .= "( :isbn, :titulo, :autor, :precio, :categoriaLibro_catLibId);";
            
            $inserta = $this->conexion->prepare($query);
            $inserta->bindParam(":isbn",$registro['isbn']);
            $inserta->bindParam(":titulo",$registro['titulo']);
            $inserta->bindParam(":autor",$registro['autor']);
            $inserta->bindParam(":precio",$registro['precio']);
            $inserta->bindParam(":categoriaLibro_catLibId",$registro['categoriaLibro_catLibId']);
            $insercion = $inserta->execute();
            $clavePrimariaConQueInserto = $this->conexion->lastInsertId();
            return ['inserto' => 1,'resultado' => $clavePrimariaConQueInserto];
            
        } catch (Exception $pdoExc) {
            return ['insert' => 0, 'resultado' =>$pdoExc];
        }
    }
    
    public function actualizar($registro){
        try{
            $autor = $registro['autor']; 
            $titulo = $registro['titulo']; 
            $precio = $registro['precio']; 
            $categoria = $registro['categoriaLibro_catLibId']; 
            $isbn = $registro['isbn']; 
            
            
            if(isset($isbn)){
                $actualizar = "UPDATE libros SET autor= ?, titulo= ?, precio= ?, categoriaLibro_catLibId= ? WHERE isbn= ?";
                $actualizacion = $this->conexion->prepare($actualizar);
                $actualizacion = $actualizacion->execute(array($autor,$titulo,$precio,$categoria,$isbn));
                return['actualización' => $actualizacion, 'mensaje' => "Actualización realizada"];
            }
        } catch (PDOException $pdoExc) {
            $err = ['mensaje' =>$pdoExc];
            return ("Error al actualizar " . $err['mensaje']);
        }
    }
    
    public function eliminar($sId=array()){
        $planConsulta = "DELETE FROM libros";
        $planConsulta .= " WHERE isbn = :isbn ;";
        $eliminar = $this->conexion->prepare($planConsulta);
        $eliminar->bindParam(':isbn', $sId[0], PDO::PARAM_INT);
        $eliminar->execute();
        
        $this->cierreBd();
        
        if(!empty($resultado)){
            return ['eliminar' => TRUE, 'registroEliminado' => array($sId[0])];
        }
        else{
            return ['eliminar' => FALSE, 'registroEliminado' => array($sId[0])];
        }
     }
     
     public function eliminarLogico($sId=array()){
         try{  
                $cambiarEstado = 0;
            
            if(isset($sId[0])){
                $eliminarLogico = "UPDATE libros SET estado= ? WHERE isbn= ?;";
                $eliminacionLogica = $this->conexion->prepare($eliminarLogico);
                $eliminacionLogica = $eliminacionLogica->execute(array($cambiarEstado,$sId[0]));
                return ['Eliminado' => $eliminacionLogica, 'Mensaje' => 'Registro ináctivo'];
            }
            
         } catch (PDOException $pdoExc) {
            return ['Mensaje' => $pdoExc];
         }        
    }
}
