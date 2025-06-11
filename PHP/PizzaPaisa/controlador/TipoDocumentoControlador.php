<?php
namespace Controlador;

use modelar\TipoDocumento;
use conectar\Conexion;

class TipoDocumentoControlador
{
    private $model;

    public function __construct()
    {
        $this->model = new TipoDocumento();
    }

    public function modificar($data)
    {
        $this->model->idTipoDocumento = $data['idTipoDocumento'];
        $this->model->tipoDocumento   = $data['tipoDocumento'];
        $this->model->modificar();
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
        while ($row = $result->fetch_assoc()) $datos[] = $row;
        $stmt->close();
        return $datos;
    }

    public function listar()
    {
        $c = (new Conexion())->conectando();
        $sql = "SELECT * FROM tipodocumento";
        $res = $c->query($sql);
        $datos = [];
        while ($row = $res->fetch_assoc()) $datos[] = $row;
        return $datos;
    }
}
?>