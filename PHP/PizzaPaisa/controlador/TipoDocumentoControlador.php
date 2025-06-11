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
        $this->model->tipoDocumento = $data['tipoDocumento'];
        $this->model->modificar();
    }

    public function buscar($idTipoDocumento)
    {
        return $this->model->buscar($idTipoDocumento);
    }
    public function listar()
    {
        return $this->model->listar();
    }
}
