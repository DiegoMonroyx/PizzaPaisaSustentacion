<?php
namespace Controlador;

use modelar\OrdenDeCompra;
use conectar\Conexion;

class OrdenCompraControlador {
    public $model;

    public function __construct()
    {
        $this->model = new OrdenDeCompra();
    }
    public function guardar($data) {
        $this->model->idOrden = $data['idOrden'];
        $this->model->fechaPedido = $data['FechaPedido'];
        $this->model->usuarioDocumento = $data['UsuarioDocumento'];
        $this->model->agregar();
    }

    public function modificar($data) {
        $this->model->idOrden = $data['idOrden'];
        $this->model->fechaPedido = $data['FechaPedido'];
        $this->model->usuarioDocumento = $data['UsuarioDocumento'];
        $this->model->modificar();
    }

    public function eliminar($idOrden) {
        $this->model->idOrden = $idOrden;
        $this->model->eliminar();
    }

    public function buscar($idOrden) {
        $cone = new Conexion();
        $c = $cone->conectando();
        $stmt = $c->prepare("SELECT * FROM ordendecompra WHERE idOrden LIKE ?");
        $search = "%{$idOrden}%";
        $stmt->bind_param("s", $search);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_array();
        $stmt->close();
        return $res;
    }

    public function listar($desde = null, $maximoRegistros = null) {
        $cone = new Conexion();
        $c = $cone->conectando();
        $sql2 = "SELECT * FROM ordendecompra";
        if ($desde !== null && $maximoRegistros !== null) {
            $sql2 .= " LIMIT $desde, $maximoRegistros";
        }
        $ejecuta = mysqli_query($c, $sql2);
        $datos = [];
        while ($row = mysqli_fetch_assoc($ejecuta)) {
            $datos[] = $row;
        }
        return $datos;
    }
}
?>