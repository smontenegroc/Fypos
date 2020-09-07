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
<input type="text" name="proId" id="proId">
