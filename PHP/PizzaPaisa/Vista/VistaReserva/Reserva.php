<?php
    include("../../conectar/conexion.php");
    include('../../controlador/ReservaControlador.php');
    use conectar\Conexion;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elcrud</title>
    <link rel="stylesheet" href="../../Config/css/bootstrap.min.css">
    <link rel="stylesheet" href="../estilos.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://kit.fontawesome.com/7e532953a9.js" crossorigin="anonymous"></script>
</head>
<body>
    <main id="mainadmin">
        <!-- ... tus modales ... -->
        <div class="modal fade" id="Reservar" data-bs-keyboard="false" tabindex="-1" style="color: Black;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="" method="post">
                        <div class="modal-header">
                            <h5 class="modal-title">Reserva</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Pedido</label>
                                <input type="text" name="idPedido" class="form-control" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Fecha Realizacion</label>
                                <input type="datetime-local" name="FechaHoraRealizacio" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Entregado</label>
                                <input type="text" name="Entregada" value="NO" class="form-control" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Fecha/hora de entrega</label>
                                <input type="datetime-local" name="FechaHoraEntrega" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">PrecioTotal</label>
                                <input type="number" name="PrecioTotal" class="form-control" value="0" readonly>
                                <div class="valid-feedback">Looks good!</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Numero de Documento</label>
                                <input type="text" class="form-control" name="UsuarioDocumento" required>
                            </div>       
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" name="guardar" class="btn btn-primary">Reservar</button>
                        </div>
                    </form> 
                </div>
            </div>
        </div>

        <!-- Modal editar -->
        <div class="modal fade" id="editar" data-bs-keyboard="false" tabindex="-1" style="color: Black;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="" method="post">
                        <div class="modal-header">
                            <h5 class="modal-title">Modificar</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Pedido</label>
                                <input type="text" name="idPedido" id="idPedido" class="form-control" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Fecha Realizacion</label>
                                <input type="text" name="FechaHoraRealizacio" id="FechaHoraRealizacio" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Entregado</label>
                                <input type="number" name="Entregada" id="Entregada" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Fecha/hora de entrega</label>
                                <input type="text" name="FechaHoraEntrega" id="FechaHoraEntrega" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">PrecioTotal</label>
                                <input type="number" name="PrecioTotal" id="PrecioTotal" class="form-control" required>
                                <div class="valid-feedback">Looks good!</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Numero de Documento</label>
                                <input type="text" class="form-control" name="UsuarioDocumento" id="UsuarioDocumento" required>
                            </div> 
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="modifica" class="btn btn-primary">Modificar</button>
                        </div>
                    </form> 
                </div>
            </div>
        </div>

        <!-- Modal eliminar -->
        <div class="modal fade" id="botoneliminar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="" method="post">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" style="color:black">Confirmar Eliminacion</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="color: black;">
                            <div class="col-12">
                                <label class="form-label">idPedido</label>
                                <input type="text" name="idPedido" id="idPedido1" class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="elimina" class="btn btn-danger">Confirmar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div> 

        <div class="container-md bg-light mt-5 py-4 px-4" id="catlos" style="width:1100px;">
            <div class="container-fluid mb-3 mt-4 d-flex justify-content-between">
                <form action="" method="post" id="form-buscar">
                    <input class="me-2" id="mortorbusq" name="idPedido" type="search" placeholder="Search" aria-label="Search" style="width:400px;">
                    <button class="btn btn-outline-success" name="buscar" value="buscar" type="submit">Search</button>
                </form>
            </div>
            <table class="table border border-1 border-dark rounded-3 bg-light" id="latabla">
                <thead style="background-color: #239227;">
                    <tr style="color: white;">
                        <th>Pedido</th>
                        <th>FechoRealizacion</th>
                        <th>Entregada</th>
                        <th>FechaHoraEntrega</th>
                        <th>PrecioTotal</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Accion</th>
                    </tr>
                </thead>
                <tbody>
<?php
if (
    (isset($is_object) && $is_object && $ejecuta->num_rows == 0) ||
    (isset($is_object) && !$is_object && mysqli_num_rows($ejecuta) == 0)
) {
    echo "<tr><td colspan='8'>No hay registros</td></tr>";
} else {
    while ($res = (isset($is_object) && $is_object) ? $ejecuta->fetch_array() : mysqli_fetch_array($ejecuta)) {
        $pedidoID = $res[0];
        $esEntregado = isset($res[2]) && $res[2] == 1;
?>
                    <tr>
                        <td><?php echo $pedidoID; ?></td>
                        <td><?php echo $res[1]; ?></td>
                        <td>
                            <button
                                class="btn btn-sm btn-entregada <?= $esEntregado ? 'btn-success' : 'btn-warning' ?>"
                                data-id="<?= htmlspecialchars($res[0]) ?>"
                                data-entregada="<?= $esEntregado ? '1' : '0' ?>">
                                <?= $esEntregado ? 'Entregado' : 'No Entregado' ?>
                            </button>
                        </td>
                        <td><?php echo $res[3]; ?></td>
                        <td><?php echo $res[4]; ?></td>
                        <td><?php echo $res[6]; ?></td>
                        <td><?php echo $res[7]; ?></td>
                        <td>
                            <form class="d-flex justify-content-center align-items-center" action="" method="post">
                                <button type="button" class="btn btn-sm btn-success toggle-details" data-id="<?php echo $pedidoID; ?>">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger elimin">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-primary boton editM" style="color:black;">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <tr class="detalle-pedido" id="detalle-<?php echo $pedidoID; ?>" style="display:none;">
                        <td colspan="8">
                            <div class="detalle-contenedor" style="margin:auto 25%; flex-direction: center;">
                                <div class="detalle-con"></div>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>ID Sabor</th>
                                            <th>Nombre de la Pizza</th>
                                            <th>Cantidad de Porciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php
    $detalleSQL = "SELECT l.idSabor, Nombre_Pizza, l.NumeroPorciones FROM linea l JOIN sabor s ON l.idSabor = s.idSabor WHERE l.idPedido = '$pedidoID'";
    $c = new Conexion();
    $cone = $c->conectando();
    $detalleEjecuta = mysqli_query($cone, $detalleSQL);
    if ($detalleEjecuta) {
        while ($detalle = mysqli_fetch_assoc($detalleEjecuta)) {
?>
                                        <tr>
                                            <td><?php echo $detalle['idSabor']; ?></td>
                                            <td><?php echo $detalle['Nombre_Pizza']; ?></td>
                                            <td><?php echo $detalle['NumeroPorciones']; ?></td>
                                        </tr>
<?php
        }
    } else {
        echo "<tr><td colspan='3'>No hay detalles disponibles</td></tr>";
    }
?>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
<?php
    }
}
?>
                </tbody>
            </table>
            <!-- Aquí tu paginación -->
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../Config/js/bootstrap.min.js"></script>
    <script src="function.js"></script>
    <script>
    $(document).ready(function(){
        $('.editM').on('click', function(){
            $('#editar').modal('show');
            $tr = $(this).closest('tr');
            var data = $tr.children('td').map(function(){
                return $(this).text();    
            }).get();
            $('#idPedido').val(data[0]);
            $('#FechaHoraRealizacio').val(data[1]);
            $('#Entregada').val(data[2]);
            $('#FechaHoraEntrega').val(data[3]);
            $('#PrecioTotal').val(data[4]);
            $('#UsuarioDocumento').val(data[5]);
        });

        $('.elimin').on('click', function(){
            $('#botoneliminar').modal('show');
            $tr = $(this).closest('tr');
            var data = $tr.children('td').map(function(){
                return $(this).text();    
            }).get();
            $('#idPedido1').val(data[0]);
        });

        $(".btn-entregada").click(function() {
            let button = $(this);
            let idPedido = button.data("id");
            let nuevoEstado = button.data("entregada") == "1" ? "0" : "1";
            $.ajax({
                url: "../../controlador/ReservaControlador.php",
                type: "POST",
                data: { idPedido: idPedido, entregada: nuevoEstado },
                dataType: "json",
                success: function(resp) {
                    if (resp.status === "success") {
                        Swal.fire({
                            icon: "success",
                            title: "Estado Actualizado",
                            text: resp.message,
                            timer: 1500,
                            showConfirmButton: false
                        });
                        if (nuevoEstado == "1") {
                            button.removeClass("btn-warning").addClass("btn-success").text("Entregado");
                            button.data("entregada", "1");
                        } else {
                            button.removeClass("btn-success").addClass("btn-warning").text("No Entregado");
                            button.data("entregada", "0");
                        }
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: resp.message || "No se pudo actualizar el estado del pedido."
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "Hubo un problema con la solicitud."
                    });
                }
            });
        });

        // Mostrar/ocultar detalles
        $(".toggle-details").on('click', function () {
            let pedidoID = $(this).data("id");
            let detalleRow = $("#detalle-" + pedidoID);
            detalleRow.toggle();
        });
    });
    </script>
</body>
</html>