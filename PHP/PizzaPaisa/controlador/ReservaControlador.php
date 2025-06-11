<?php
namespace Controlador;

require_once __DIR__ . '/../vendor/autoload.php';
use modelar\Reserva;
use conectar\Conexion;


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajax_cambiar_entregada'])) {
    // Si tienes autoload, NO necesitas require_once aquí
    $ctrl = new ReservaControlador();
    if (isset($_POST['idPedido'], $_POST['nuevoEstado'])) {
        $ctrl->cambiarEstadoEntregada($_POST['idPedido'], $_POST['nuevoEstado']);
    } else {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => 'Parámetros faltantes']);
        exit;
    }
    exit;
}

class ReservaControlador {
    public $model;

    public function __construct() {
        $this->model = new Reserva();
    }

    public function guardar($data) {
        $this->model->idPedido = $data['idPedido'];
        $this->model->fechaHoraRealizacio = $data['FechaHoraRealizacio'];
        $this->model->entregada = $data['Entregada'];
        $this->model->fechaHoraEntrega = $data['FechaHoraEntrega'];
        $this->model->precioTotal = $data['PrecioTotal'];
        $this->model->usuarioDocumento = $data['UsuarioDocumento'];
        $this->model->agregar();
    }

    public function modificar($data) {
        $this->model->idPedido = $data['idPedido'];
        $this->model->fechaHoraRealizacio = $data['FechaHoraRealizacio'];
        $this->model->entregada = $data['Entregada'];
        $this->model->fechaHoraEntrega = $data['FechaHoraEntrega'];
        $this->model->precioTotal = $data['PrecioTotal'];
        $this->model->usuarioDocumento = $data['UsuarioDocumento'];
        $this->model->modificar();
    }

    public function eliminar($id) {
        $this->model->idPedido = $id;
        $this->model->eliminar();
    }

    public function buscar($id) {
        $c = new Conexion();
        $cone = $c->conectando();
        $stmt = $cone->prepare("SELECT * FROM reserva WHERE idPedido LIKE ?");
        $search = "%{$id}%";
        $stmt->bind_param("s", $search);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_array();
        $stmt->close();
        return $res;
    }

    public function listar() {
        $cone = new Conexion();
        $c = $cone->conectando();
        $sql = "SELECT r.idPedido, r.created_at, r.Entregada, r.FechaHoraEntrega, r.PrecioTotal,
                       u.UsuarioDocumento, u.UsuarioPrimerNombre, u.UsuarioApellido
                FROM reserva r
                INNER JOIN usuario u ON r.UsuarioDocumento = u.UsuarioDocumento
                ORDER BY r.idPedido DESC";
        $ejecuta = mysqli_query($c, $sql);
        $datos = [];
        while ($row = mysqli_fetch_assoc($ejecuta)) {
            $datos[] = $row;
        }
        return $datos;
    }

    // Este método debe estar en la clase:
    public function cambiarEstadoEntregada($idPedido, $nuevoEstado) {
        $resultado = $this->model->cambiarEstadoEntregada($idPedido, $nuevoEstado);
        if (ob_get_length()) ob_end_clean();
        header('Content-Type: application/json');
        if ($resultado) {
            echo json_encode(['status' => 'success', 'message' => 'Estado actualizado']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No se pudo actualizar el estado']);
        }
        exit;
    }
}