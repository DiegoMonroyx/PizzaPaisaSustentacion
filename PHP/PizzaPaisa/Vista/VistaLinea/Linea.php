<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use Controlador\LineaControlador;

$ctrl = new LineaControlador();
if (isset($_POST['guardar'])) {
    $ctrl->guardar($_POST);
}
if (isset($_POST['modifica'])) {
    $ctrl->modificar($_POST);
}
if (isset($_POST['elimina'])) {
    $ctrl->eliminar($_POST['idOrden']);
}

$lineas = $ctrl->listar();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elcrud</title>
    <link rel="stylesheet" href="../../Config/css/bootstrap.min.css">
    <link rel="stylesheet" href="../estilos.css">
    <script href="../Config/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/7e532953a9.js" crossorigin="anonymous"></script>
    <script src="function.js"></script>
</head>
<body>
    
    <main id="mainadmin">
        <div class="modal fade" id="Reservar" name=""   data-bs-keyboard="false" tabindex="-1" aria-labelledby="" aria-hidden="" style="color: Black;">
        <div class="modal-dialog">
            <div class="modal-content">
            <form action="" class="" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Linea</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body row g-3">
                                     
                        <div class="col-md-6">
                                <label for="inputAddress" class="form-label">Pedido</label>
                                <input type="text" name="idPedido" id="" class="form-control" >
                        </div>
                        <div class="col-md-6">
                            <label for="inputAddress2" class="form-label">Sabor</label>
                            <input type="text" name="idSabor" id="" class="form-control"  placeholder="">
                        </div>
                        <div class="col-md-6">
                                <label for="inputPassword4" class="form-label">Numero de porciones</label>
                                <input type="number" name="NumeroPorciones" id="" value="" class="form-control" >
                         </div>
                         
                        
                        
                     
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit"   name="guardar" class="btn btn-primary">Aceptar</button>
                </div>
            </div>
            </form> 
         </div>
        </div>


<!-- modal editar-->
    <div class="modal fade" id="editar" name=""   data-bs-keyboard="false" tabindex="-1" aria-labelledby="" aria-hidden="" style="color: Black;">
        <div class="modal-dialog">
            <div class="modal-content">
            <form action="" class="" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Modificar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body row g-3">
                                     
                        <div class="col-md-6">
                                <label for="inputAddress" class="form-label">Pedido</label>
                                <input type="text" name="idPedido" id="idPedido" class="form-control" readonly>
                        </div>
                        <div class="col-md-6">
                            <input type="hidden" name="idSabores" id="idSabores" class="form-control"  placeholder="">
                            <label for="inputAddress2" class="form-label">Sabor</label>
                            <input type="text" name="idSabor" id="idSabor" class="form-control"  placeholder="">
                        </div>
                        <div class="col-md-6">
                                <label for="inputPassword4" class="form-label">Numero de Porciones</label>
                                <input type="number" name="NumeroPorciones" id="NumeroPorciones" class="form-control"  >
                         </div>
                        <div class="col-md-6">
                                <label for="inputEmail4" class="form-label">Precio</label>
                                <input type="text" name="" id="PrecioPorcion" class="form-control" readonly >
                        </div>
                        <div class="col-md-6">
                            <label for="validationCustom01" class="form-label">NumeroDocumento</label readonly>
                            <input type="number" name="" id="UsuarioDocumento" class="form-control" value="" readonly required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                       
                        
                        
                     
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit"  href="UsuarioAdmin.php" name="modifica" class="btn btn-primary">modificar</button>
                </div>
            </div>
            </form> 
         </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" class="botone" id="botoneliminar" name="Eliminar1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="" method="post">
              <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" style="color:black">Confirmar Eliminacion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="color: black;">
                            <div class="col-12">
                                    <label for="inputAddress" class="form-label">idPedido</label>
                                    <input type="text" name="idPedido" id="idPedido1" class="form-control"  >
                            </div>
                            <div class="col-12">
                                    <label for="inputAddress" class="form-label">idSabor</label>
                                    <input type="text" name="idSabor" id="idSabor1" class="form-control"  >
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
        
    <div class="container-md bg-light mt-5 py-4 px-4" style ="width:1100px; ">
    
            
            
        <div class="container-fluid mb-3 mt-4 d-flex justify-content-between ">
            
            <form action="" method="post" id="form-buscar">
            <input class=" me-2 " id="mortorbusq" name="idPedido" type="search" placeholder="Search" aria-label="Search" style="width:400px;">
            <button class="btn btn-outline-success" name="buscar" value="buscar" type="submit">Search</button>
            </form>
            
            <button type="button"  class="btn btn-primary d-flex  m-3  " style="heigth:20px ;" data-bs-toggle="modal" data-bs-target="#Reservar">
            Reserva
            </button>
           
        </div>
            <table class="table border border-1 border-dark rounded-3 bg-light" id="latabla">
                <thead class="" id="succes" style="background-color: #239227;">
                    <tr style="color: white;">
                        <th scope="col">Pedido</th>
                        <th scope="col">idSabor</th>
                        <th scope="col">Pizza</th>
                        <th scope="col">Precio</th>
                        <th scope="col">NumeroPorciones</th>
                        <th scope="col">Documento</th>
                        <th scope="col">Accion</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (!empty($lineas)): ?>
                    <?php foreach ($lineas as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['idPedido']) ?></td>
                            <td><?= htmlspecialchars($row['idSabor']) ?></td>
                            <td><?= htmlspecialchars($row['Nombre_Pizza']) ?></td>
                            <td><?= htmlspecialchars($row['Precio_Porcion']) ?></td>
                            <td><?= htmlspecialchars($row['numeroPorciones']) ?></td>
                            <td><?= htmlspecialchars($row['UsuarioDocumento']) ?></td>
                            <td>
                                <form class="d-flex justify-content-center align-items-center" action="" method="post">
                                    <button type="button" class="btn btn-sm btn-danger elimin"><i class="fa-solid fa-trash"></i></button>
                                    <button type="button" class="btn btn-sm btn-primary boton editM" style="color:black;"><i class="fa-solid fa-pen-to-square"></i></button>
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
    $(document).ready(function(){
        $('.editM').on('click', function(){
            $('#editar').modal('show');
            $tr = $(this).closest('tr');
            var data = $tr.children('td').map(function(){
                return $(this).text();
            }).get();
            $('#idPedido').val(data[0]);
            $('#idSabor').val(data[1]);
            $('#idSabores').val(data[1]);
            $('#NumeroPorciones').val(data[4]);
            $('#PrecioPorcion').val(data[3]);
            $('#UsuarioDocumento').val(data[5]);
        });

        $('.elimin').on('click', function(){
            $('#botoneliminar').modal('show');
            $tr = $(this).closest('tr');
            var data = $tr.children('td').map(function(){
                return $(this).text();
            }).get();
            $('#idPedido1').val(data[0]);
            $('#idSabor1').val(data[1]);
        });
    });
</script>