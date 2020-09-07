<?php

class ValidarProducto{
    
    
    
    public function validarFormularioProducto($datos) {      
        $mensajesError = NULL;
        $datosViejos = NULL;
        $marcaCampo = NULL;
     
        foreach ($datos as $key => $value){
            switch ($key){
                case 'proId':
                   validarId($value,$mensajesError); 
                break;
            }
        }
    }
    
    public function validarId($value,$mensajesError){
        $patronDocumento = "/^[[:digit:]]+$/";
            if(!preg_match($patronDocumento, $value)){
            $mensajesError['proId']="*1-Formato/Dato incorrecto";                        
        }
    }
}

