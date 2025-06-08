<?php
include_once __DIR__ . '/../modelar/ReservaModelo.php';
include_once __DIR__ . '/../conectar/conexion.php';

use conectar\Conexion;
use modelar\Reserva;

$obj = new Reserva();

$cone  = new Conexion();
$c = $cone->conectando();

$sql1 = "SELECT count(*) as totalRegistro FROM reserva";
$ejecuta1 = mysqli_query($c, $sql1);
$res1 = mysqli_fetch_array($ejecuta1);
$totalRegistros = $res1['totalRegistro'];
$maximoRegistros = 6;

$pagina = empty($_GET['pagina']) ? 1 : $_GET['pagina'];
$desde = ($pagina - 1) * $maximoRegistros;
$totalPaginas = ceil($totalRegistros / $maximoRegistros);

if (isset($_POST['idPedido'], $_POST['entregada'])) {
    $reserva = new \modelar\Reserva();
    $reserva->idPedido = $_POST['idPedido'];
    $reserva->entregada = $_POST['entregada'];
    $reserva->modificarr(); // Este método debe responder JSON
    exit;
}
//echo json_encode(["status" => "error", "message" => "Faltan datos"]);

if(isset($_POST['buscar'])){
    $obj->idPedido = $_POST['idPedido'];
    $sql2 = "SELECT r.idPedido, r.created_at, r.Entregada, r.FechaHoraEntrega, r.PrecioTotal,
        u.UsuarioDocumento, u.UsuarioPrimerNombre, u.UsuarioApellido
        FROM reserva r
        INNER JOIN usuario u ON r.UsuarioDocumento = u.UsuarioDocumento
        WHERE r.idPedido LIKE ? 
        ORDER BY r.idPedido DESC
        LIMIT ?, ?";
    $stmt = $c->prepare($sql2);
    $likeIdPedido = "%" . $obj->idPedido . "%";
    $stmt->bind_param("sii", $likeIdPedido, $desde, $maximoRegistros);
    $stmt->execute();
    $ejecuta = $stmt->get_result();
    $is_object = true;
    $stmt->close();
} else {
    $sql2 = "SELECT r.idPedido, r.created_at, r.Entregada, r.FechaHoraEntrega, r.PrecioTotal,
        u.UsuarioDocumento, u.UsuarioPrimerNombre, u.UsuarioApellido
        FROM reserva r
        INNER JOIN usuario u ON r.UsuarioDocumento = u.UsuarioDocumento
        ORDER BY r.idPedido DESC";
    $ejecuta = mysqli_query($c, $sql2);
    $is_object = false;
}
?>