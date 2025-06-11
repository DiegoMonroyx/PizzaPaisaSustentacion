<?php
namespace Controlador;

use modelar\TipoUsuario;
use conectar\Conexion;

class TipoUsuarioControlador
{
    private $model;

    public function __construct()
    {
        $this->model = new TipoUsuario();
    }

    public function modificar($data)
    {
        $this->model->idTipoUsuario = $data['idTipoUsuario'];
        $this->model->tipoUsuario   = $data['tipoUsuario'];
        $this->model->modificar();
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