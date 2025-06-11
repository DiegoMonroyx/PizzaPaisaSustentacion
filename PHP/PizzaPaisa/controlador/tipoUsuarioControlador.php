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
        $this->model->tipoUsuario = $data['tipoUsuario'];
        $this->model->modificar();
    }
    public function buscar($idTipoUsuario)
    {
        return $this->model->buscar($idTipoUsuario);
    }
    public function listar()
    {
        return $this->model->listar();
    }
}
