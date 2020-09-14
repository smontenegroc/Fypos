<?php
if(isset($_SESSION['registroProveedor'])){
    $registroProveedor = $_SESSION['registroProveedor'];
    $cantProveedores = count($registroProveedor);
}

if (isset($_SESSION['erroresValidacion'])) {
    $erroresValidacion = $_SESSION['erroresValidacion'];
    unset($_SESSION['erroresValidacion']);
}
?>
<h2>Insertar producto</h2>
<form method="post" action="Controlador.php">
    Producto: <input type="text" name="proNombre" id="proNombre"><br><br>
    Descripción: <input type="text" name="proDescripcion" id="proDescripcion"><br><br>
    Precio: <input type="text" name="proPrecio" id="proPrecio"><br><br>
    Cantidad: <input type="text" name="proCantidad" id="proCantidad"><br><br>
    Proveedor: <select id="provId" name="provId">
        <?php
        for($i=0;$i<$cantProveedores;$i++){
        ?>
        <option value="<?php echo $registroProveedor[$i]->provId; ?>">
        <?php echo $registroProveedor[$i]->provId." - ". $registroProveedor[$i]->provNombre; ?>
        </option>
        <?php } ?>
    </select><br><br>
    <button type="submit" name="ruta" value="insertarProducto">Agregar Producto</button>
</form>

