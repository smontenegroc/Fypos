<?php
if(isset($_SESSION['mensaje'])){
    $mensaje = $_SESSION['mensaje'];
    echo "<script languaje='javascript'>alert('$mensaje')</script>";
    unset($_SESSION['mensaje']);
}

if (isset($_SESSION['actualizarDatosProducto'])) {
    $actualizarDatosProducto = $_SESSION['actualizarDatosProducto'];
    unset($_SESSION['actualizarProducto']);
}

if(isset($_SESSION['registroProveedor'])){
    $registroProveedor = $_SESSION['registroProveedor'];
    $cantProveedores = count($registroProveedor);
}
if(isset($_SESSION['erroresValidacion'])){
    $erroresValidacion = $_SESSION['erroresValidacion'];
    unset($_SESSION['erroresValidacion']);
}
//echo '<pre>';
//print_r($actualizarDatosProducto);
//print_r($registroProveedor);
//echo '</pre>';
//exit();
?>

<h2>Actualizar Producto</h2>


<form method="post" action="Controlador.php" id="formRegistro">
    <div>
        <!--Id: <span name="proId"><?php // if(isset($actualizarDatosProducto->proId)){echo $actualizarDatosProducto->proId;} ?></span><br><br>-->
        Id: <input type="text" name="proId" value=<?php if(isset($actualizarDatosProducto->proId)){echo $actualizarDatosProducto->proId;} ?> readonly><br><br>
        Producto <input type="text" name="proNombre" value=<?php if(isset($actualizarDatosProducto->proNombre)){echo $actualizarDatosProducto->proNombre;}?>><br><br>
        Descripción: <input type="text" name="proDescripcion" value=<?php if(isset($actualizarDatosProducto->proDescripcion)){echo $actualizarDatosProducto->proDescripcion;}?>><br><br>
        Precio: <input type="text" name="proPrecio" value=<?php if(isset($actualizarDatosProducto->proPrecio)){echo $actualizarDatosProducto->proPrecio;}?>><br><br>
        Cantidad: <input type="text" name="proCantidad" value=<?php if(isset($actualizarDatosProducto->proCantidad)){echo $actualizarDatosProducto->proCantidad;}?>><br><br>
        <select id="proveedores" name="proveedores">
            <?php
            for($i=0;$i<$cantProveedores;$i++){
            ?>
            <option 
                value="<?php echo $registroProveedor[$i]->provId; ?>" 
                <?php
                if(isset($registroProveedor[$i]->provId) && isset($actualizarDatosProducto->provNombre)
                        && ($registroProveedor[$i]->provNombre == $actualizarDatosProducto->provNombre)){
                    echo 'selected';
                }
                ?>
                >
                <?php echo $registroProveedor[$i]->provId . " - " . $registroProveedor[$i]->provNombre;?>                
            </option>
            <?php }?>
        </select><br><br>
        <button type="reset" name="ruta" value="cancelarActualizarProducto">Cancelar</button>&nbsp;&nbsp;||&nbsp;&nbsp;
        <button type="submit" name="ruta" value="confirmaActualizarProducto">Actualizar Producto    </button>
    </div>
</form>



