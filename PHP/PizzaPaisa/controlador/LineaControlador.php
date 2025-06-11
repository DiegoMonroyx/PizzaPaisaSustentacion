<?php
namespace Controlador;

use modelar\Linea;
use conectar\Conexion;

class LineaControlador {
    public $model;

    public function __construct()
    {
        $this->model = new Linea();
    }
    public function guardar($data) {
        $this->model->idSabor         = $data['idSabor'];
        $this->model->idPedido        = $data['idPedido'];
        $this->model->numeroPorciones = $data['NumeroPorciones'];
        $this->model->agregar();
    }

    public function modificar($data) {
        $this->model->idSabor         = $data['idSabor'];
        $this->model->idPedido        = $data['idPedido'];
        $this->model->numeroPorciones = $data['NumeroPorciones'];
        $this->model->modificar();
    }

    public function eliminar($idPedido, $idSabor) {
        $this->model->idPedido = $idPedido;
        $this->model->idSabor  = $idSabor;
        $this->model->eliminar();
    }

    public function buscar($idPedido) {
        $cone = new Conexion();
        $c = $cone->conectando();
        $stmt = $c->prepare("SELECT * FROM linea WHERE idPedido LIKE ?");
        $search = "%{$idPedido}%";
        $stmt->bind_param("s", $search);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_array();
        $stmt->close();
        return $res;
    }

    public function listar() {
    $cone = new Conexion();
    $c = $cone->conectando();
    $sql2 = "SELECT l.idPedido, 
                    s.idSabor, 
                    Nombre_Pizza, 
                    (numeroPorciones * Precio_Porcion) AS Precio_Porcion, 
                    numeroPorciones, 
                    UsuarioDocumento 
             FROM linea l 
             INNER JOIN reserva r ON l.idPedido = r.idPedido
             INNER JOIN sabor s ON l.idSabor = s.idSabor 
             ORDER BY l.idPedido ASC";
    $ejecuta = mysqli_query($c, $sql2);
    $datos = [];
    while ($row = mysqli_fetch_assoc($ejecuta)) {
        $datos[] = $row;
    }
    return $datos;
}
}
?>