<?php
namespace modelar;

use conectar\Conexion;

class SaborIngrediente
{
    public $idSabor;
    public $idIngrediente;
    public $idIngredientes; // para edición (el valor original)
    public $cantidadKg;

    public function agregar()
    {
        $c = (new Conexion())->conectando();
        // Verifica si ya existe
        $query = "SELECT * FROM saboringrediente WHERE idSabor = ? AND idIngrediente = ?";
        $stmt = $c->prepare($query);
        $stmt->bind_param("ss", $this->idSabor, $this->idIngrediente);
        $stmt->execute();
        $result = $stmt->get_result();

        if (!$result->fetch_array()) {
            $insert = "INSERT INTO saboringrediente (idSabor, idIngrediente, Cantidadkg) VALUES (?, ?, ?)";
            $stmt2 = $c->prepare($insert);
            $stmt2->bind_param("ssd", $this->idSabor, $this->idIngrediente, $this->cantidadKg);
            $stmt2->execute();
            $stmt2->close();
            echo "<script>Swal.fire({ icon: 'success', title: 'Registro agregado', timer: 2000, showConfirmButton: false });</script>";
        } else {
            echo "<script>Swal.fire({ icon: 'info', title: 'Ya existe', timer: 2000, showConfirmButton: false });</script>";
        }
        $stmt->close();
    }

    public function modificar()
    {
        $c = (new Conexion())->conectando();
        // Verifica si existe el registro original
        $query = "SELECT * FROM saboringrediente WHERE idSabor = ? AND idIngrediente = ?";
        $stmt = $c->prepare($query);
        $stmt->bind_param("ss", $this->idSabor, $this->idIngredientes);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->fetch_array()) {
            $update = "UPDATE saboringrediente SET idIngrediente = ?, Cantidadkg = ? WHERE idSabor = ? AND idIngrediente = ?";
            $stmt2 = $c->prepare($update);
            $stmt2->bind_param("sdsd", $this->idIngrediente, $this->cantidadKg, $this->idSabor, $this->idIngredientes);
            $stmt2->execute();
            $stmt2->close();
            echo "<script>Swal.fire({ icon: 'success', title: 'Registro actualizado', timer: 2000, showConfirmButton: false });</script>";
        } else {
            echo "<script>Swal.fire({ icon: 'error', title: 'Registro no encontrado', timer: 2000, showConfirmButton: false });</script>";
        }
        $stmt->close();
    }

    public function eliminar()
    {
        $c = (new Conexion())->conectando();
        $delete = "DELETE FROM saboringrediente WHERE idSabor = ? AND idIngrediente = ?";
        $stmt = $c->prepare($delete);
        $stmt->bind_param("ss", $this->idSabor, $this->idIngrediente);
        if ($stmt->execute()) {
            echo "<script>Swal.fire({ icon: 'success', title: 'Registro eliminado', timer: 2000, showConfirmButton: false });</script>";
        } else {
            echo "<script>Swal.fire({ icon: 'warning', title: 'No se puede eliminar', timer: 2000, showConfirmButton: false });</script>";
        }
        $stmt->close();
    }

}