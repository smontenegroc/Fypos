<?php
if(isset($_SESSION['listaDeProveedores'])){
    $listaDeProveedores = $_SESSION['listaDeProveedores'];
}
?>

<table id="example"  class="table-responsive table-hover table-bordered table-striped" style="width:100%">
    <thead>
        <tr>
            <th>ID</th>
            <th>Proveedor</th>
            <th>Teléfono</th>
            <th>Dirección</th>
            <th>Mail</th>
            <th>Actualizar</th>
            <th>Eliminar</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 0;
        foreach ($listaDeProveedores as $key => $value) {
            ?>
            <tr>
                <td><?php echo $listaDeProveedores[$i]->provId;?></td>  
                <td><?php echo $listaDeProveedores[$i]->provNombre; ?></td>  
                <td><?php echo $listaDeProveedores[$i]->provTelefono; ?></td>  
                <td><?php echo $listaDeProveedores[$i]->provDireccion; ?></td>
                <td><?php echo $listaDeProveedores[$i]->provMail; ?></td>
                <td><a href="Controlador.php?ruta=actualizarProveedor&idAct=<?php echo $listaDeProveedores[$i]->provId; ?>"><i class="far fa-edit"></a></td>
                <td>
                    <a href="Controlador.php?ruta=eliminarProveedor&idEli=<?php echo $listaDeProveedores[$i]->provId; ?>" 
                       onclick="return confirm('Está seguro de eliminar el registro?')">
                       <i class="fas fa-trash-alt"></i>
                    </a>
                </td>  
            </tr>   
            <?php $i++;
        } ?>
    </tbody>
</table>

