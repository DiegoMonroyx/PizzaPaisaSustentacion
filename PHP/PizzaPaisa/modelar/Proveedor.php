<?php
namespace modelar;
use conectar\Conexion;

class Proveedor
{
    public $barrio;
    public $direccion;
    public $idProveedor;
    public $nombreProveedor;
    public $numeroTelefono;

    public function agregar()
    {
        $conet = new Conexion();
        $c = $conet->conectando();
        $query = "SELECT * FROM proveedor WHERE idProveedor = ?";
        $stmt = $c->prepare($query);
        $stmt->bind_param("i", $this->idProveedor);
        $stmt->execute();
        $ejecuta = $stmt->get_result();
        if ($ejecuta && $ejecuta->fetch_array()) {
            echo '<script>Swal.fire({position: "top", icon: "info", title: "El proveedor ya existe en el sistema", showConfirmButton: false, timer: 3000});</script>';
        } else {
            $insertar = "INSERT INTO proveedor (idProveedor, NombreProveedor, NumeroTelefono, direccion, barrio) VALUES (?, ?, ?, ?, ?)";
            $stmt_insert = $c->prepare($insertar);
            $stmt_insert->bind_param(
                "issss",
                $this->idProveedor,
                $this->nombreProveedor,
                $this->numeroTelefono,
                $this->direccion,
                $this->barrio
            );
            if ($stmt_insert->execute()) {
                echo '<script>Swal.fire({position: "top", icon: "success", title: "Proveedor agregado correctamente", showConfirmButton: false, timer: 3000});</script>';
            } else {
                echo '<script>Swal.fire({position: "top", icon: "error", title: "Error agregando el proveedor", showConfirmButton: false, timer: 3000});</script>';
            }
            $stmt_insert->close();
        }
        $stmt->close();
    }

    public function modificar()
    {
        $c = new Conexion();
        $cone = $c->conectando();
        $sql = "SELECT * FROM proveedor WHERE idProveedor = ?";
        $stmt = $cone->prepare($sql);
        $stmt->bind_param("i", $this->idProveedor);
        $stmt->execute();
        $r = $stmt->get_result();
        if (!$r->fetch_array()) {
            echo "<script> alert('El proveedor no existe en el sistema')</script>";
        } else {
            $id = "UPDATE proveedor SET 
                NombreProveedor = ?, 
                NumeroTelefono = ?, 
                direccion = ?, 
                barrio = ? 
                WHERE idProveedor = ?";
            $stmt_update = $cone->prepare($id);
            $stmt_update->bind_param(
                "ssssi",
                $this->nombreProveedor,
                $this->numeroTelefono,
                $this->direccion,
                $this->barrio,
                $this->idProveedor
            );
            if ($stmt_update->execute()) {
                echo '<script>Swal.fire({position: "top", icon: "success", title: "Proveedor actualizado correctamente", showConfirmButton: false, timer: 3000});</script>';
            } else {
                echo '<script>Swal.fire({position: "top", icon: "error", title: "Error actualizando el proveedor", showConfirmButton: false, timer: 3000});</script>';
            }
            $stmt_update->close();
        }
        $stmt->close();
    }

    public function eliminar()
    {
        try {
            $c = new Conexion();
            $cone = $c->conectando();
            $sql = "DELETE FROM proveedor WHERE idProveedor = ?";
            $stmt = $cone->prepare($sql);
            $stmt->bind_param("i", $this->idProveedor);
            if ($stmt->execute()) {
                echo '<script>Swal.fire({position: "top",icon: "success", title: "Proveedor eliminado correctamente", showConfirmButton: false, timer: 3000});</script>';
            } else {
                echo '<script>Swal.fire({position: "top", icon: "warning", title: "No se puede eliminar el proveedor porque tiene datos relacionados", showConfirmButton: false, timer: 3000});</script>';
            }
            $stmt->close();
        } catch (\Exception $e) {
            echo '<script>Swal.fire({position: "top", icon: "warning", title: "No se puede eliminar el proveedor porque tiene datos relacionados", showConfirmButton: false, timer: 3000});</script>';
        }
    }
}
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>