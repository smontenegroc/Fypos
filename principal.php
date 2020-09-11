        <?php
session_start();
include_once 'modelos\ConstantesConexion.php';
if(isset($_SESSION['mensaje'])){
    $mensaje = $_SESSION['mensaje'];
    echo "<script languaje='javascript'>alert('$mensaje')</script>";
    unset($_SESSION['mensaje']);
}
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>FYPOS</title>
        
        <link href="startbootstrap-sb-admin-2-gh-pages/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
        <link href="startbootstrap-sb-admin-2-gh-pages/css/sb-admin-2.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css"> 
        <script src="https://kit.fontawesome.com/b778b1c697.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" type="text/css" href="./estilos.css">
        
    </head>
    <body>        
        <header class="panel-top">
            <p>User</p>
        </header>
        <div class="container">
            <section class="panel-left">
                <p>Fypos</p>
                <nav>
                    <ul>
                        <li><a href="Controlador.php?ruta=listarProductos&pag=0">Productos</a></li>
                        <li><a href="Controlador.php?ruta=listarProveedores">Proveedores</a></li>
                        <li><a href="Controlador.php?ruta=listarVendedores">Vendedores</a></li>
                    </ul>
                </nav>
            </section>
            <section class="content">
            <?php
                if(isset($_GET['contenido'])){
                    include($_GET['contenido']);
                }
            ?>
            </section>
        </div>      
       
        
        
        
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript">
                $(document).ready(function () {
                    $('#example').DataTable({
                        pageLength: 10,
                        lengthMenu: [[5, 10,15,20], [5, 10,15,20]],
                        language: {
                            emptyTable: "No hay datos",
                            info: "_END_ registros de _TOTAL_",
                            infoFiltered: "",
                            lengthMenu: "Mostrar _MENU_ registros",
                            search: "Buscar:",
                            zeroRecords: "No hay coincidencias",
                            paginate: {
                                next: "Siguiente",
                                previous: "Anterior"
                            }
                        }
                    });
                });
            </script> 
    </body>
</html>

