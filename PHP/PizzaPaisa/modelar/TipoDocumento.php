<?php
namespace modelar;
use conectar\Conexion;

class TipoDocumento
{
    public $idTipoDocumento;
    public $tipoDocumento;

    public function modificar()
    {
        $c = (new Conexion())->conectando();
        // Verifica si existe
        $sql = "SELECT * FROM tipodocumento WHERE idTipoDocumento = ?";
        $stmt = $c->prepare($sql);
        $stmt->bind_param("s", $this->idTipoDocumento);
        $stmt->execute();
        $r = $stmt->get_result();

        if (!$r->fetch_array()) {
            echo "<script>Swal.fire({icon:'error',title:'No se puede modificar el tipo de documento',timer:2000,showConfirmButton:false});</script>";
        } else {
            $id = "UPDATE tipodocumento SET tipoDocumento = ? WHERE idTipoDocumento = ?";
            $stmt_update = $c->prepare($id);
            $stmt_update->bind_param("ss", $this->tipoDocumento, $this->idTipoDocumento);
            $stmt_update->execute();
            $stmt_update->close();

            echo "<script>Swal.fire({icon:'success',title:'Tipo de documento actualizado',timer:2000,showConfirmButton:false});</script>";
        }
        $stmt->close();
    }

    public function buscar($idTipoDocumento)
    {
        $c = (new Conexion())->conectando();
        $sql = "SELECT * FROM tipodocumento WHERE idTipoDocumento LIKE ?";
        $stmt = $c->prepare($sql);
        $like = "%$idTipoDocumento%";
        $stmt->bind_param("s", $like);
        $stmt->execute();
        $result = $stmt->get_result();
        $datos = [];
        while ($row = $result->fetch_assoc()) {
            $datos[] = $row;
        }
        $stmt->close();
        return $datos;
    }

    public function listar()
    {
        $c = (new Conexion())->conectando();
        $sql = "SELECT * FROM tipodocumento";
        $res = $c->query($sql);
        $datos = [];
        while ($row = $res->fetch_assoc()) {
            $datos[] = $row;
        }
        return $datos;
    }
}
?>
