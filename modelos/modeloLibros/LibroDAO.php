<?php

class LibroDAO  extends ConBdMysql{
    private $cantidadTotalRegistros;
    
    function construct($servidor,$base,$loginBD,$passwordBD){
        parent::__construct($servidor, $base, $loginBD, $passwordBD);
    }
    
    public function seleccionarTodos(){
        $planConsulta = "select l.isbn,l,titulo,l.autor,l.precio,cl.catLibId,cl.catLibNombre";
        $planConsulta .=" from libros l join categorialibro cl";
        $planConsulta .=" ON l.categoriaLibro_CatLibId = cl.catLibId";
        $planConsulta .=" order by l.isbn ASC";
    }
}
