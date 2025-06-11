<?php
namespace Controlador;

use modelar\Sabor;
use conectar\Conexion;

class SaborControlador
{
    private $model;

    public function __construct()
    {
        $this->model = new Sabor();
    }

    public function guardar($data)
    {
        $this->model->idSabor       = $data['idSabor'];
        $this->model->nombrePizza   = $data['NombrePizza'];
        $this->model->precioPorcion = $data['PrecioPorcion'];
        $this->model->agregar();
    }

    public function modificar($data)
    {
        $this->model->idSabor       = $data['idSabor'];
        $this->model->nombrePizza   = $data['NombrePizza'];
        $this->model->precioPorcion = $data['PrecioPorcion'];
        $this->model->modificar();
    }

    public function eliminar($idSabor)
    {
        $this->model->idSabor = $idSabor;
        $this->model->eliminar();
    }

    public function buscar($idSabor)
    {
        $c = (new Conexion())->conectando();
        $query = "SELECT * FROM sabor WHERE idSabor LIKE ?";
        $stmt = $c->prepare($query);
        $like = "%$idSabor%";
        $stmt->bind_param("s", $like);
        $stmt->execute();
        $result = $stmt->get_result();
        $sabores = [];
        while ($row = $result->fetch_assoc()) {
            $sabores[] = $row;
        }
        $stmt->close();
        return $sabores;
    }

    public function listar()
    {
        $c = (new Conexion())->conectando();
        $result = $c->query("SELECT * FROM sabor ORDER BY idSabor ASC");
        $sabores = [];
        while ($row = $result->fetch_assoc()) {
            $sabores[] = $row;
        }
        return $sabores;
    }
}