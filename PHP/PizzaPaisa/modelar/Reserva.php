<?php
namespace modelar;
use conectar\Conexion;

class Reserva {
    public $idPedido;
    public $fechaHoraRealizacio;
    public $entregada;
    public $fechaHoraEntrega;
    public $precioTotal;
    public $usuarioDocumento;

    public function agregar() {
        $conet = new Conexion();
        $c = $conet->conectando();

        $query = "SELECT * FROM reserva WHERE idPedido = ?";
        $stmt = $c->prepare($query);
        $stmt->bind_param("i", $this->idPedido);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result && $result->fetch_array()){
            echo '<script>Swal.fire({
                position: "top", icon: "info",
                title: "La reserva ya existe en el sistema",
                showConfirmButton: false, timer: 3000
            });</script>';
        } else {
            $insertar = "INSERT INTO reserva (idPedido, FechaHoraRealizacio, Entregada, FechaHoraEntrega, PrecioTotal, UsuarioDocumento) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt_insert = $c->prepare($insertar);
            $stmt_insert->bind_param("isssds", $this->idPedido, $this->fechaHoraRealizacio, $this->entregada, $this->fechaHoraEntrega, $this->precioTotal, $this->usuarioDocumento);
            $stmt_insert->execute();
            $stmt_insert->close();
            echo '<script>Swal.fire({
                position: "top", icon: "success",
                title: "Reserva agregada correctamente",
                showConfirmButton: false, timer: 3000
            });</script>';
        }
        $stmt->close();
    }

    public function modificar() {
        $c = new Conexion();
        $cone = $c->conectando();
        $sql = "SELECT * FROM reserva WHERE idPedido = ?";
        $stmt = $cone->prepare($sql);
        $stmt->bind_param("i", $this->idPedido);
        $stmt->execute();
        $result = $stmt->get_result();
        if(!$result || !$result->fetch_array()){
            echo "<script> alert('La reserva no existe en el sistema')</script>";
        } else {
            $id = "UPDATE reserva SET FechaHoraRealizacio = ?, Entregada = ?, FechaHoraEntrega = ?, PrecioTotal = ?, UsuarioDocumento = ? WHERE idPedido = ?";
            $stmt_update = $cone->prepare($id);
            $stmt_update->bind_param("sssdsi", $this->fechaHoraRealizacio, $this->entregada, $this->fechaHoraEntrega, $this->precioTotal, $this->usuarioDocumento, $this->idPedido);
            $stmt_update->execute();
            $stmt_update->close();
            echo '<script>Swal.fire({
                position: "top", icon: "success",
                title: "Reserva actualizada correctamente",
                showConfirmButton: false, timer: 3000
            });</script>';
        }
        $stmt->close();
    }

    public function eliminar() {
        try {
            $c = new Conexion();
            $cone = $c->conectando();
            $sql = "DELETE FROM reserva WHERE idPedido = ?";
            $stmt = $cone->prepare($sql);
            $stmt->bind_param("i", $this->idPedido);
            $stmt->execute();
            $stmt->close();
            echo '<script>Swal.fire({
                position: "top", icon: "success",
                title: "Reserva eliminada correctamente",
                showConfirmButton: false, timer: 3000
            });</script>';
        } catch (\Exception $e) {
            echo '<script>Swal.fire({
                position: "top", icon: "warning",
                title: "La reserva no se puede eliminar porque tiene datos relacionados",
                showConfirmButton: false, timer: 3000
            });</script>';
        }
    }

    public function cambiarEstadoEntregada($idPedido, $nuevoEstado) {
    $c = new Conexion();
    $con = $c->conectando();
    $sql = "UPDATE reserva SET Entregada=? WHERE idPedido=?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ii", $nuevoEstado, $idPedido);
    $success = $stmt->execute();
    $stmt->close();
    return $success;
    }
}
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>