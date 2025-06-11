<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Controlador\TipoUsuarioControlador;

$ctrl = new TipoUsuarioControlador();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['modifica'])) {
        $ctrl->modificar($_POST);
    }
}

if (isset($_POST['buscar']) && !empty($_POST['idTipoUsuario'])) {
    $datos = $ctrl->buscar($_POST['idTipoUsuario']);
} else {
    $datos = $ctrl->listar();
}
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tipo Usuario</title>
    <link rel="stylesheet" href="../../Config/css/bootstrap.min.css">
    <link rel="stylesheet" href="../estilos.css">
    <script src="https://kit.fontawesome.com/7e532953a9.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
  </head>
  <body>
    <div style="display: flex; justify-content: center; align-items: center; min-height: 100vh;">
      <div style="width: 60%;">
        <form action="" method="post" class="mb-3 d-flex">
          <input type="text" class="form-control me-2" name="idTipoUsuario" placeholder="Buscar por ID">
          <button class="btn btn-outline-success" name="buscar" type="submit">Buscar</button>
        </form>
        <table class="table table-bordered border-1 border--bs-secondary-color table-hover bg-light" id="tabla" style="border-radius: 10px; overflow: hidden;">
            <thead class="border-1 border-dark" id="succes" style="background-color: #239227;">
                <tr style="color: white">
                  <th scope="col">id</th>
                  <th scope="col" style="text-align: center;">Tipo de Usuario</th>
                  <th scope="col">Acción</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                <?php
                if (empty($datos)) {
                    echo "<tr><td colspan='3' style='text-align: center;'>No hay registros</td></tr>";
                } else {
                    foreach ($datos as $row) {
                        ?>
                        <tr>
                            <td><?= htmlspecialchars($row['idTipoUsuario']) ?></td>
                            <td><?= htmlspecialchars($row['tipoUsuario']) ?></td>
                            <td style="text-align: center;">
                              <button type="button" class="btn btn-sm btn-primary boton editM" style="color: black;"><i class="fa-solid fa-pen-to-square"></i></button>
                            </td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </tbody>
        </table>
      </div>
    </div>
    <!-- Modal Editar -->
    <div class="modal fade" id="editar" data-bs-keyboard="false" tabindex="-1" aria-labelledby="" aria-hidden="true" style="color: Black;">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title">Modificar</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body row g-3">
                        <div class="col-md-6">
                            <label class="form-label">id Tipo Usuario</label>
                            <input type="number" name="idTipoUsuario" id="idTipoUsuario" class="form-control" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tipo de Usuario</label>
                            <input type="text" name="tipoUsuario" id="tipoUsuario" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" name="modifica" class="btn btn-success">Modificar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script>
      $(document).ready(function(){
        $('.editM').on('click', function(){
          $('#editar').modal('show');
          var $tr = $(this).closest('tr');
          var data = $tr.children('td').map(function(){
            return $(this).text();
          }).get();
          $('#idTipoUsuario').val(data[0]);
          $('#tipoUsuario').val(data[1]);
        });
      });
    </script>
  </body>
</html>