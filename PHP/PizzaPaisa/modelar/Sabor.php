<?php
namespace modelar;

use conectar\Conexion;

class Sabor
{
    public $idSabor;
    public $nombrePizza;
    public $precioPorcion;

    public function agregar()
    {
        $c = (new Conexion())->conectando();
        $query = "SELECT * FROM sabor WHERE idSabor = ?";
        $stmt = $c->prepare($query);
        $stmt->bind_param("s", $this->idSabor);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result && $result->fetch_array()) {
            echo "<script>Swal.fire({ icon: 'info', title: 'El Sabor ya existe', timer: 2000, showConfirmButton: false });</script>";
        } else {
            $insert = "INSERT INTO sabor (idSabor, Nombre_Pizza, Precio_Porcion) VALUES (?, ?, ?)";
            $stmt2 = $c->prepare($insert);
            $stmt2->bind_param("ssd", $this->idSabor, $this->nombrePizza, $this->precioPorcion);
            if ($stmt2->execute()) {
                echo "<script>Swal.fire({ icon: 'success', title: 'Sabor agregado', timer: 2000, showConfirmButton: false });</script>";
            } else {
                echo "<script>Swal.fire({ icon: 'error', title: 'Error al agregar', timer: 2000, showConfirmButton: false });</script>";
            }
            $stmt2->close();
        }
        $stmt->close();
    }

    public function modificar()
    {
        $c = (new Conexion())->conectando();
        $update = "UPDATE sabor SET Nombre_Pizza = ?, Precio_Porcion = ? WHERE idSabor = ?";
        $stmt2 = $c->prepare($update);
        $stmt2->bind_param("sds", $this->nombrePizza, $this->precioPorcion, $this->idSabor);
        if ($stmt2->execute()) {
            echo "<script>Swal.fire({ icon: 'success', title: 'Sabor actualizado', timer: 2000, showConfirmButton: false });</script>";
        } else {
            echo "<script>Swal.fire({ icon: 'error', title: 'Error al actualizar', timer: 2000, showConfirmButton: false });</script>";
        }
        $stmt2->close();
    }

    public function eliminar()
    {
        $c = (new Conexion())->conectando();
        $delete = "DELETE FROM sabor WHERE idSabor = ?";
        $stmt = $c->prepare($delete);
        $stmt->bind_param("s", $this->idSabor);
        if ($stmt->execute()) {
            echo "<script>Swal.fire({ icon: 'success', title: 'Sabor eliminado', timer: 2000, showConfirmButton: false });</script>";
        } else {
            echo "<script>Swal.fire({ icon: 'warning', title: 'No se puede eliminar', timer: 2000, showConfirmButton: false });</script>";
        }
        $stmt->close();
    }

}