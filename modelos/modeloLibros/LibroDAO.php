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
        
        $planConsulta = "select * from libros l";
        $planConsulta .= " where l.isbn=? ;";
        
        $listar = $this->conexion->prepare($planConsulta);
        $listar->execute(array($sId[0]));
        
        $registroEncontrado = array();
        
        while($registro = $listar->fetch(PDO::FETCH_OBJ)){
            $registroEncontrado[] = $registro; 
        }
        $this->cierreBd();
        if(!empty($registroEncontrado)){
            return ['exitoSeleccionId' => 1 , 'registroEncontrado' => $registroEncontrado];
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
            
        } catch (Exception $ex) {
            return ['insert' => 0, 'resultado' =>$pdoExc];
        }
    }
}
