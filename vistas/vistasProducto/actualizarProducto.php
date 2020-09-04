<?php

if (isset($_SESSION['actualizarDatosProducto'])) {
    $actualizarDatosLibro = $_SESSION['actualizarDatosProducto'];
    unset($_SESSION['actualizarProducto']);
}

if(isset($_SESSION['registroProveedor'])){
    $registroProveedor = $_SESSION['registroProveedor'];
    $cantProveedores = count($registroProveedor);
}
?>

<h2>Actualizar Producto</h2>


<form>
    <div>
        <span><?php if(isset($actualizarDatosLibro->proId)){echo $actualizarDatosLibro->proId;} ?></span>
        <input type="text" value=<?php if(isset($actualizarDatosLibro->proNombre)){echo $actualizarDatosLibro->proNombre;}?>>
        <input type="text" value=<?php if(isset($actualizarDatosLibro->proDescripcion)){echo $actualizarDatosLibro->proDescripcion;}?>>
        <input type="text" value=<?php if(isset($actualizarDatosLibro->proPrecio)){echo $actualizarDatosLibro->proPrecio;}?>>
        <input type="text" value=<?php if(isset($actualizarDatosLibro->proCantidad)){echo $actualizarDatosLibro->proCantidad;}?>>
        
    </div>
</form>



