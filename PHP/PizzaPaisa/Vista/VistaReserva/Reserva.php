<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Controlador\ReservaControlador;
use conectar\Conexion;

$ctrl = new ReservaControlador();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar'])) {
    $ctrl->guardar($_POST);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modifica'])) {
    $ctrl->modificar($_POST);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['elimina'])) {
    $ctrl->eliminar($_POST['idPedido']);
}

$reservas = $ctrl->listar();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elcrud</title>
    <link rel="stylesheet" href="../../Config/css/bootstrap.min.css">
    <link rel="stylesheet" href="../estilos.css">
    <script src="function.js"></script>
    <!-- SweetAlert2 SIN integrity ni crossorigin -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJ+Y3ZZo2Xsn3b52bQyGQmGhZgJ1J4b8bBz0I="
        crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/7e532953a9.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-cVKIphbuKT1zEhlKU6Fa6l5gWQ5l9F2s4l2F5jR8LqjEjh4u57rR1aVt3+0U6bKG"
        crossorigin="anonymous"></script>
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
            <button type="button" class="btn btn-primary d-flex m-3" style="height:20px;" data-bs-toggle="modal" data-bs-target="#Reservar">
                Añadir Reserva
            </button>
        </div>
        <table class="table border border-1 border-dark rounded-3 bg-light" id="latabla">
            <thead style="background-color: #239227;">
                <tr style="color: white;">
                    <th>Pedido</th>
                    <th>Fecha Creación</th>
                    <th>Entregada</th>
                    <th>Fecha/Hora Entrega</th>
                    <th>PrecioTotal</th>
                    <th>Documento</th>
                    <th>Apellido</th>
                    <th>Acción</th>
                </tr>
            </thead>
        <tbody>
            <?php if ($reservas && count($reservas) > 0): ?>
                <?php foreach ($reservas as $row): 
                    $pedidoID = $row['idPedido'];
                    $entregada = $row['Entregada'];
                ?>
                <tr>
                    <td><?= htmlspecialchars($pedidoID) ?></td>
                    <td><?= htmlspecialchars($row['created_at']) ?></td>
                    <td>
                        <button class="btn btn-sm btn-entregada <?= $entregada ? 'btn-success' : 'btn-warning' ?>"
                            data-id="<?= htmlspecialchars($pedidoID) ?>"
                            data-entregada="<?= $entregada ? '1' : '0' ?>">
                            <?= $entregada ? 'Entregado' : 'No Entregado' ?>
                        </button>
                    </td>
                    <td><?= htmlspecialchars($row['FechaHoraEntrega']) ?></td>
                    <td><?= htmlspecialchars($row['PrecioTotal']) ?></td>
                    <td><?= htmlspecialchars($row['UsuarioDocumento']) ?></td>
                    <td><?= htmlspecialchars($row['UsuarioApellido']) ?></td>
                    <td>
                        <form style="display:inline;">
                            <button type="button" class="btn btn-sm btn-success toggle-details" data-id="<?= $pedidoID ?>">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-danger elimin"><i class="fa-solid fa-trash"></i></button>
                            <button type="button" class="btn btn-sm btn-primary editM"><i class="fa-solid fa-pen-to-square"></i></button>
                        </form>
                    </td>
                </tr>

                <!-- Fila de detalles OCULTA por defecto -->
                <tr class="detalle-pedido" id="detalle-<?= $pedidoID ?>" style="display:none;">
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
                <?php endforeach; ?>
                <?php else: ?>
                <tr>
                    <td colspan="8">No hay registros</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>

<script>
$(document).ready(function(){
    // Editar
    $('.editM').on('click', function(){
        $('#editar').modal('show');
        $tr = $(this).closest('tr');
        var data = $tr.children('td').map(function(){
            return $(this).text();    
        }).get();
        $('#idPedido').val(data[0]);
        $('#FechaHoraRealizacio').val(data[1]);
        $('#Entregada').val(data[2].trim() === "Entregado" ? 1 : 0);
        $('#FechaHoraEntrega').val(data[3]);
        $('#PrecioTotal').val(data[4]);
        $('#UsuarioDocumento').val(data[5]);
    });

    // Eliminar
    $('.elimin').on('click', function(){
        $('#botoneliminar').modal('show');
        $tr = $(this).closest('tr');
        var data = $tr.children('td').map(function(){
            return $(this).text();    
        }).get();
        $('#idPedido1').val(data[0]);
    });

    $(document).on('click', '.btn-entregada', function(){
    var idPedido = $(this).data("id");
    var estadoActual = $(this).data("entregada");
    var nuevoEstado = estadoActual == 1 ? 0 : 1;
    var boton = $(this);

    $.ajax({
        url: "../../controlador/ReservaControlador.php",
        type: "POST",
        data: { ajax_cambiar_entregada: 1, idPedido: idPedido, nuevoEstado: nuevoEstado },
        dataType: "json",
        success: function(resp) {
            // Si entra aquí es porque el backend devolvió JSON bien formado
            console.log('RESPUESTA JSON:', resp);
            if(resp.status === "success") {
                boton.toggleClass('btn-success btn-warning');
                boton.text(nuevoEstado == 1 ? 'Entregado' : 'No Entregado');
                boton.data('entregada', nuevoEstado);
            }
            Swal.fire({
                icon: resp.status === "success" ? "success" : "error",
                title: resp.status === "success" ? 'Actualizado' : 'Error',
                text: resp.message
            });
        },
        error: function(xhr, status, error) {
            // Aquí puedes ver la respuesta EXACTA que está devolviendo el backend
            console.log('XHR:', xhr);
            console.log('Status:', status);
            console.log('Error:', error);
            console.log('Respuesta del servidor:', xhr.responseText); // <--- AQUÍ VERÁS EL HTML O ERROR PHP
            Swal.fire({
                icon: "error",
                title: "Error de red",
                text: "No se pudo contactar al servidor: " + error
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