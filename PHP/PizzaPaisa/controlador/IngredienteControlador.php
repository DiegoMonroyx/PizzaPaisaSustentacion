<?php
namespace Controlador;

use modelar\Ingrediente;
use conectar\Conexion;

class IngredienteControlador {
    public $model;

    public function __construct()
    {
        $this->model = new Ingrediente();
    }
    public function guardar($data) {
        $this->model->idIngrediente = $data['idIngrediente'];
        $this->model->descripcion   = $data['Descripcion'];
        $this->model->existenciaskg = $data['Existenciaskg'];
        $this->model->agregar();
    }

    public function modificar($data) {
        $this->model->idIngrediente = $data['idIngrediente'];
        $this->model->descripcion   = $data['Descripcion'];
        $this->model->existenciaskg = $data['Existenciaskg'];
        $this->model->modificar();
    }

    public function eliminar($id) {
        $this->model->idIngrediente = $id;
        $this->model->eliminar();
    }

    public function buscar($id) {
        $cone = new Conexion();
        $c = $cone->conectando();
        $stmt = $c->prepare("SELECT * FROM ingrediente WHERE idIngrediente LIKE ?");
        $search = "%{$id}%";
        $stmt->bind_param("s", $search);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_array();
        $stmt->close();
        return $res;
    }

    public function listar() {
    $cone = new Conexion();
    $c = $cone->conectando();
    $sql2 = "SELECT * FROM ingrediente";
    $ejecuta = mysqli_query($c, $sql2);
    $datos = [];
    while ($row = mysqli_fetch_assoc($ejecuta)) {
        $datos[] = $row; // Cada $row es un array asociativo
    }
    return $datos; // Devuelve un array de arrays
}
}