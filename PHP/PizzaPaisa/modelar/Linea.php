<?php
namespace modelar;
use conectar\Conexion;

class Linea {

    public $idSabor;
    public $idPedido;
    public $numeroPorciones;

    public function agregar(){
        $conet = new Conexion();
        $c = $conet->conectando();

        // Verifica si la línea ya existe usando consulta preparada
        $query = "SELECT * FROM linea WHERE idPedido = ? AND idSabor = ?";
        $stmt = $c->prepare($query);
        $stmt->bind_param("ss", $this->idPedido, $this->idSabor);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result && $result->fetch_array()){
            echo '<script>Swal.fire({
                position: "top",
                icon: "info",
                title: "La Línea ya Existe en el Sistema",
                showConfirmButton: false,
                timer: 3000
            });</script>';
        } else {
            // Inserta la nueva línea usando consulta preparada
            $insertar = "INSERT INTO linea (idSabor, idPedido, numeroPorciones) VALUES (?, ?, ?)";
            $stmt_insert = $c->prepare($insertar);
            $stmt_insert->bind_param("ssi", $this->idSabor, $this->idPedido, $this->numeroPorciones);
            $stmt_insert->execute();
            $stmt_insert->close();
            echo '<script>
                Swal.fire({
                    position: "top",
                    icon: "success",
                    title: "La Línea Fue Agregada en el Sistema",
                    showConfirmButton: false,
                    timer: 3000
                });
            </script>';
        }
        $stmt->close();
    }

    public function modificar(){
        $conet = new Conexion();
        $c = $conet->conectando();

        // Verifica si la línea existe
        $sql = "SELECT * FROM linea WHERE idPedido = ? AND idSabor = ?";
        $stmt = $c->prepare($sql);
        $stmt->bind_param("ss", $this->idPedido, $this->idSabor);
        $stmt->execute();
        $result = $stmt->get_result();

        if(!$result || !$result->fetch_array()){
            echo "<script> alert('La Línea no existe en el Sistema')</script>";
        } else {
            // Actualiza usando consulta preparada
            $update = "UPDATE linea SET numeroPorciones = ? WHERE idPedido = ? AND idSabor = ?";
            $stmt_update = $c->prepare($update);
            $stmt_update->bind_param("iss", $this->numeroPorciones, $this->idPedido, $this->idSabor);
            $stmt_update->execute();
            $stmt_update->close();
            echo '<script>
                Swal.fire({
                    position: "top",
                    icon: "success",
                    title: "La Línea Fue Actualizada en el Sistema",
                    showConfirmButton: false,
                    timer: 3000
                });
            </script>';
        }
        $stmt->close();
    }

    public function eliminar(){
        try{
            $conet = new Conexion();
            $c = $conet->conectando();

            // Elimina usando consulta preparada
            $sql = "DELETE FROM linea WHERE idPedido = ? AND idSabor = ?";
            $stmt = $c->prepare($sql);
            $stmt->bind_param("ss", $this->idPedido, $this->idSabor);
            $stmt->execute();
            $stmt->close();

            echo '<script>Swal.fire({
                position: "top",
                icon: "success",
                title: "La Línea Fue Eliminada del Sistema",
                showConfirmButton: false,
                timer: 3000
            });</script>';
        }catch(\Exception $e){
            echo '<script>Swal.fire({
                position: "top",
                icon: "warning",
                title: "La Línea no se Puede Eliminar Porque Tiene Datos Relacionados",
                showConfirmButton: false,
                timer: 3000
            });</script>';
        }
    }
}
?>
