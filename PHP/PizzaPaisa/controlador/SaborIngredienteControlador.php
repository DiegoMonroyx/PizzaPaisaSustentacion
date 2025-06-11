<?php
namespace Controlador;

use modelar\SaborIngrediente;
use conectar\Conexion;

class SaborIngredienteControlador
{
    private $model;

    public function __construct()
    {
        $this->model = new SaborIngrediente();
    }

    public function guardar($data)
    {
        $this->model->idSabor      = $data['idSabor'];
        $this->model->idIngrediente = $data['idIngrediente'];
        $this->model->cantidadKg    = $data['Cantidadkg'];
        $this->model->agregar();
    }

    public function modificar($data)
    {
        $this->model->idSabor       = $data['idSabor'];
        $this->model->idIngrediente = $data['idIngrediente'];
        $this->model->idIngredientes = $data['idIngredientes']; // para edición
        $this->model->cantidadKg    = $data['Cantidadkg'];
        $this->model->modificar();
    }

    public function eliminar($idSabor, $idIngrediente)
    {
        $this->model->idSabor = $idSabor;
        $this->model->idIngrediente = $idIngrediente;
        $this->model->eliminar();
    }

    public function buscar($idSabor)
    {
        $c = (new Conexion())->conectando();
        $query = "SELECT sa.idSabor, s.Nombre_Pizza, i.idIngrediente, i.Descripcion, sa.Cantidadkg
                  FROM saboringrediente sa
                  INNER JOIN sabor s ON s.idSabor = sa.idSabor
                  INNER JOIN ingrediente i ON i.idIngrediente = sa.idIngrediente
                  WHERE sa.idSabor LIKE ?
                  ORDER BY sa.idSabor ASC";
        $stmt = $c->prepare($query);
        $like = "%$idSabor%";
        $stmt->bind_param("s", $like);
        $stmt->execute();
        $result = $stmt->get_result();
        $rows = [];
        while ($row = $result->fetch_assoc()) $rows[] = $row;
        $stmt->close();
        return $rows;
    }

    public function listar()
    {
        $c = (new Conexion())->conectando();
        $query = "SELECT sa.idSabor, s.Nombre_Pizza, i.idIngrediente, i.Descripcion, sa.Cantidadkg
                  FROM saboringrediente sa
                  INNER JOIN sabor s ON s.idSabor = sa.idSabor
                  INNER JOIN ingrediente i ON i.idIngrediente = sa.idIngrediente
                  ORDER BY sa.idSabor ASC";
        $result = $c->query($query);
        $rows = [];
        while ($row = $result->fetch_assoc()) $rows[] = $row;
        return $rows;
    }

}