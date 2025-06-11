<?php
namespace modelar;

use conectar\Conexion;

class TipoUsuario
{
    public $idTipoUsuario;
    public $tipoUsuario;

    public function modificar()
    {
        $c = (new Conexion())->conectando();

        $sql = "SELECT * FROM tipousuario WHERE idTipoUsuario = ?";
        $stmt = $c->prepare($sql);
        $stmt->bind_param("s", $this->idTipoUsuario);
        $stmt->execute();
        $r = $stmt->get_result();

        if (!$r->fetch_array()) {
            echo "<script> alert('No se puede modificar el tipo de usuario') </script>";
        } else {
            $id = "UPDATE tipousuario SET tipoUsuario = ? WHERE idTipoUsuario = ?";
            $stmt_update = $c->prepare($id);
            $stmt_update->bind_param("ss", $this->tipoUsuario, $this->idTipoUsuario);
            $stmt_update->execute();
            $stmt_update->close();

            echo '<script> Swal.fire({
                position: "top",
                icon: "success",
                title: "El tipo de usuario se actualizó con éxito",
                showConfirmButton: false,
                timer: 3000});
                </script>';
        }
        $stmt->close();
    }

    public function buscar($idTipoUsuario)
    {
        $c = (new Conexion())->conectando();
        $sql = "SELECT * FROM tipousuario WHERE idTipoUsuario LIKE ?";
        $stmt = $c->prepare($sql);
        $like = "%$idTipoUsuario%";
        $stmt->bind_param("s", $like);
        $stmt->execute();
        $result = $stmt->get_result();
        $datos = [];
        while ($row = $result->fetch_assoc()) $datos[] = $row;
        $stmt->close();
        return $datos;
    }

    public function listar()
    {
        $c = (new Conexion())->conectando();
        $sql = "SELECT * FROM tipousuario";
        $res = $c->query($sql);
        $datos = [];
        while ($row = $res->fetch_assoc()) $datos[] = $row;
        return $datos;
    }
}
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>