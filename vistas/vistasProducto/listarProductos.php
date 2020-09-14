<?php
if(isset($_SESSION['listaDeProductos'])){
    $listaDeProductos = $_SESSION['listaDeProductos'];
}
?>
<table id="example" class="table-responsive table-hover table-bordered table-striped" style="width:100%">
    <thead>
        <tr>
            <th>ID</th>
            <th>Producto</th>
            <th>Descripción</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Proveedor</th>
            <th>Actualizar</th>
            <th>Eliminar</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 0;
        foreach ($listaDeProductos as $key => $value) {
            ?>
            <tr>
                <td><?php echo $listaDeProductos[$i]->proId;?></td>  
                <td><?php echo $listaDeProductos[$i]->proNombre; ?></td>  
                <td><?php echo $listaDeProductos[$i]->proDescripcion; ?></td>  
                <td><?php echo $listaDeProductos[$i]->proPrecio; ?></td>
                <td><?php echo $listaDeProductos[$i]->proCantidad; ?></td>
                <td><?php echo $listaDeProductos[$i]->provNombre; ?></td> 
                <td><a href="Controlador.php?ruta=actualizarProducto&idAct=<?php echo $listaDeProductos[$i]->proId; ?>"><i class="far fa-edit"></a></td>
<!--                <td>
                    <a href="Controlador.php?ruta=actualizarProducto&idAct=<?php // echo $listaDeProductos[$i]->proId; ?>">Actualizar</a>
                </td>-->
                <td>
                    <a href="Controlador.php?ruta=eliminarProducto&idEli=<?php echo $listaDeProductos[$i]->proId; ?>" 
                       onclick="return confirm('Está seguro de eliminar el registro?')">
                       <i class="fas fa-trash-alt"></i>
                    </a>
                </td>  
            </tr>   
            <?php $i++;
        } ?>
    </tbody>
</table>
<a href="Controlador.php?ruta=mostrarInsertarProducto">Agregar Producto</a>

