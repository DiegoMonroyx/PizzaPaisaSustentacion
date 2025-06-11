<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use Controlador\OrdenIngredienteControlador;

$ctrl = new OrdenIngredienteControlador();

if (isset($_POST['guardar'])) {
    $ctrl->guardar($_POST);
}
if (isset($_POST['modifica'])) {
    $ctrl->modificar($_POST);
}
if (isset($_POST['elimina'])) {
    $ctrl->eliminar($_POST['idOrden']);
    $ctrl->eliminar($_POST['idIngrediente']);
    $ctrl->eliminar($_POST['idProveedor']);
}

if (isset($_POST['buscar'])) {
    $ordenes = $ctrl->buscar($_POST['idOrden']);
} else {
    $ordenes = $ctrl->listar();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elcrud</title>
    <link rel="stylesheet" href="../../Config/css/bootstrap.min.css">
    <link rel="stylesheet" href="../estilos.css">
    <script src="../Config/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/7e532953a9.js" crossorigin="anonymous"></script>
    <script src="function.js"></script>
</head>

<body>
    <main id="mainadmin">

<!-- Modal: Agregar Orden de Ingrediente -->
<div class="modal fade" id="Ordenar" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalOrdenarLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" style="color: black;">
      <form action="" method="post">
        <div class="modal-header">
          <h5 class="modal-title" id="modalOrdenarLabel">Órdenes de ingrediente</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body row g-3">
          <div class="col-md-6">
            <label for="idOrden" class="form-label">Id Orden</label>
            <input type="number" name="idOrden" id="idOrden" class="form-control" required>
          </div>
          <div class="col-md-6">
            <label for="idIngrediente" class="form-label">Id ingrediente</label>
            <input type="text" name="idIngrediente" id="idIngrediente" class="form-control" required>
          </div>
          <div class="col-md-6">
            <label for="CantidadSolicitada" class="form-label">Cantidad solicitada</label>
            <input type="number" name="CantidadSolicitada" id="CantidadSolicitada" class="form-control" required>
          </div>
          <div class="col-md-6">
            <label for="idProveedor" class="form-label">Id proveedor</label>
            <input type="number" name="idProveedor" id="idProveedor" class="form-control" required>
          </div>
          <div class="col-md-6">
            <label for="CantidadComprada" class="form-label">Cantidad comprada</label>
            <input type="number" name="CantidadComprada" id="CantidadComprada" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer" style="color: black;">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" name="guardar" class="btn btn-primary">Aceptar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal: Editar Orden de Ingrediente -->
<div class="modal fade" id="editar" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" style="color: black;">
      <form action="" method="post">
        <div class="modal-header">
          <h5 class="modal-title" id="modalEditarLabel">Modificar orden de ingrediente</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body row g-3">
          <div class="col-md-6">
            <label for="edit_idOrden" class="form-label">Id Orden</label>
            <input type="number" name="idOrden" id="edit_idOrden" class="form-control" readonly>
          </div>
          <div class="col-md-6">
            <label for="edit_idIngrediente" class="form-label">Id ingrediente</label>
            <input type="text" name="idIngrediente" id="edit_idIngrediente" class="form-control" readonly>
          </div>
          <div class="col-md-6">
            <label for="edit_CantidadSolicitada" class="form-label">Cantidad solicitada</label>
            <input type="number" name="CantidadSolicitada" id="edit_CantidadSolicitada" class="form-control" required>
          </div>
          <div class="col-md-6">
            <label for="edit_idProveedor" class="form-label">Id proveedor</label>
            <input type="number" name="idProveedor" id="edit_idProveedor" class="form-control" readonly>
          </div>
          <div class="col-md-6">
            <label for="edit_CantidadComprada" class="form-label">Cantidad comprada</label>
            <input type="number" name="CantidadComprada" id="edit_CantidadComprada" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer" style="color: black;">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" name="modifica" class="btn btn-primary">Modificar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal: Confirmar Eliminacion -->
<div class="modal fade" id="botoneliminar" tabindex="-1" aria-labelledby="modalEliminarLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="" method="post">
      <div class="modal-content" style="color: black;">
        <div class="modal-header">
          <h5 class="modal-title" id="modalEliminarLabel">Confirmar Eliminación</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <div class="col-12">
            <label for="idOrden1" class="form-label">Id orden</label>
            <input type="text" name="idOrden" id="idOrden1" class="form-control" readonly>
          </div>
          <div class="col-12">
            <label for="idIngrediente1" class="form-label">Id ingrediente</label>
            <input type="text" name="idIngrediente" id="idIngrediente1" class="form-control" readonly>
          </div>
          <div class="col-12">
            <label for="idProveedor1" class="form-label">Id proveedor</label>
            <input type="number" name="idProveedor" id="idProveedor1" class="form-control" readonly>
          </div>
        </div>
        <div class="modal-footer" style="color: black;">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" name="elimina" class="btn btn-danger">Confirmar</button>
        </div>
      </div>
    </form>
  </div>
</div>

        <div class="container-md bg-light mt-5 py-4 px-4" style="width:1100px; ">



            <div class="container-fluid mb-3 mt-4 d-flex justify-content-between ">

                <form action="" method="post" id="form-buscar">
                    <input class=" me-2 " id="mortorbusq" name="idOrden" type="search" placeholder="Search" aria-label="Search" style="width:400px;">
                    <button class="btn btn-outline-success" name="buscar" value="buscar" type="submit">Search</button>
                </form>

                <button type="button" class="btn btn-primary d-flex  m-3  " style="height:20px ;" data-bs-toggle="modal" data-bs-target="#Ordenar">
                    Agregar
                </button>

            </div>

            <table class="table border border-1 border-dark rounded-3 bg-light" id="latabla">
                <thead class=" " id="succes" style="background-color: #239227;">
                    <tr style="color: white;">


                        <th scope="col">Id orden</th>
                        <th scope="col">Id ingrediente</th>
                        <th scope="col">Cantidad solicitada</th>
                        <th scope="col">Id proveedor</th>
                        <th scope="col">Cantidad comprada</th>
                        <th scope="col">Fecha de compra</th>
                        <th scope="col"></th>


                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($ordenes)): ?>
                        <?php foreach ($ordenes as $row): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['idOrden']) ?></td>
                                <td><?= htmlspecialchars($row['idIngrediente']) ?></td>
                                <td><?= htmlspecialchars($row['CantidadSolicitada']) ?></td>
                                <td><?= htmlspecialchars($row['idProveedor']) ?></td>
                                <td><?= htmlspecialchars($row['CantidadComprada']) ?></td>
                                <td><?= htmlspecialchars($row['created_at']) ?></td>
                                <td>
                                    <!-- Botones de editar/eliminar: puedes hacerlos funcionar con modals y JS -->
                                    <form class="d-flex justify-content-center align-items-center" action="" method="post">
                                        <button type="button" class="btn btn-sm btn-danger elimin"><i class="fa-solid fa-trash"></i></button>
                                        <button type="button" class="btn btn-sm btn-primary editM" style="color:black;"><i class="fa-solid fa-pen-to-square"></i></button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7">No hay registros</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            
        </div>

    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>



</body>

</html>
<script>
    $(document).ready(function() {

        $('.editM').on('click', function() {
            $('#editar').modal('show');
            $tr = $(this).closest('tr');
            var data = $tr.children('td').map(function() {
                return $(this).text();
            }).get();
            console.log(data);
            $('#edit_idOrden').val(data[0]);
            $('#edit_idIngrediente').val(data[1]);
            $('#edit_CantidadSolicitada').val(data[2]);
            $('#edit_idProveedor').val(data[3]);
            $('#edit_CantidadComprada').val(data[4]);
        });

        $('.elimin').on('click', function() {
            $('#botoneliminar').modal('show');
            $tr = $(this).closest('tr');
            var data = $tr.children('td').map(function() {
                return $(this).text();
            }).get();
            console.log(data);
            $('#idOrden1').val(data[0]);
            $('#idIngrediente1').val(data[1]);
            $('#idProveedor1').val(data[3]);

        });

    });
</script>