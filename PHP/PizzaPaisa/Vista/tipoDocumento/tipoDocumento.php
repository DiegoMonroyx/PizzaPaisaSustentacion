<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Controlador\TipoDocumentoControlador;

$ctrl = new TipoDocumentoControlador();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['modifica'])) {
        $ctrl->modificar($_POST);
    }
}

if (isset($_POST['buscar']) && !empty($_POST['idTipoDocumento'])) {
    $datos = $ctrl->buscar($_POST['idTipoDocumento']);
} else {
    $datos = $ctrl->listar();
}
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tipo Documento</title>
    <link rel="stylesheet" href="../../Config/css/bootstrap.min.css">
    <link rel="stylesheet" href="../estilos.css">
    <script src="https://kit.fontawesome.com/7e532953a9.js" crossorigin="anonymous"></script>
    <script src="function.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  </head>
  <body>
    <div style="display: flex; justify-content: center; align-items: center; min-height: 100vh;">
    <div style="width: 60%;">
        <form action="" method="post" class="mb-3 d-flex">
            <input type="text" class="form-control me-2" name="idTipoDocumento" placeholder="Buscar por ID">
            <button class="btn btn-outline-success" name="buscar" type="submit">Buscar</button>
        </form>
        <table class="table table-bordered border-1 border--bs-secondary-color table-hover bg-light" id="tabla" style="border-radius: 10px; overflow: hidden;">
            <thead class="border-1 border-dark" id="succes" style="background-color: #239227;">
                <tr style="color: white">
                    <th scope="col">ID</th>
                    <th scope="col" style="text-align: center;">Tipo de Documento</th>
                    <th scope="col">Acción</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                <?php if (empty($datos)): ?>
                    <tr><td colspan="3" style="text-align: center;">No hay registros</td></tr>
                <?php else: ?>
                    <?php foreach ($datos as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['idTipoDocumento']) ?></td>
                            <td><?= htmlspecialchars($row['tipoDocumento']) ?></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary editM" style="color:black;"><i class="fa-solid fa-pen-to-square"></i></button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Editar -->
<div class="modal fade" id="editar" tabindex="-1" aria-labelledby="editarLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="" method="post" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarLabel">Modificar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body row g-3">
                <div class="col-md-6">
                    <label class="form-label">Id Tipo Documento</label>
                    <input type="number" name="idTipoDocumento" id="idTipoDocumento" class="form-control" readonly>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tipo de documento</label>
                    <input type="text" name="tipoDocumento" id="tipoDocumento" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" name="modifica" class="btn btn-success">Modificar</button>
            </div>
        </form>
    </div>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    
  </body>
  <script>
    $(document).ready(function(){
      $('.editM').on('click', function(){
        $('#editar').modal('show');
        $tr = $(this).closest('tr');
        var data = $tr.children('td').map(function(){
          return $(this).text();
        }).get();
        console.log(data);
        $('#idTipoDocumento').val(data[0]);
        $('#tipoDocumento').val(data[1]); 
      });

    });

  </script>

</html>