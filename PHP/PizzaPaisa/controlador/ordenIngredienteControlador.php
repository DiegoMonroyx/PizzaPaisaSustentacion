<?php
namespace Controlador;

use modelar\OrdenIngrediente;
use conectar\Conexion;

class OrdenIngredienteControlador {
    public $model;

    public function __construct()
    {
        $this->model = new OrdenIngrediente();
    }
    public function guardar($data) {
        $orden = new OrdenIngrediente();
        $orden->idOrden = $data['idOrden'];
        $orden->idIngrediente = $data['idIngrediente'];
        $orden->cantidadSolicitada = $data['CantidadSolicitada'];
        $orden->idProveedor = $data['idProveedor'];
        $orden->cantidadComprada = $data['CantidadComprada'];
        $orden->fechaCompra = $data['FechaCompra'];
        $orden->agregar();
    }

    public function modificar($data) {
        $orden = new OrdenIngrediente();
        $orden->idOrden = $data['idOrden'];
        $orden->idIngrediente = $data['idIngrediente'];
        $orden->cantidadSolicitada = $data['CantidadSolicitada'];
        $orden->idProveedor = $data['idProveedor'];
        $orden->cantidadComprada = $data['CantidadComprada'];
        $orden->modificar();
    }

    public function eliminar($idOrden, $idIngrediente, $idProveedor) {
        $orden = new OrdenIngrediente();
        $orden->idOrden = $idOrden;
        $orden->idIngrediente = $idIngrediente;
        $orden->idProveedor = $idProveedor;
        $orden->eliminar();
    }

    public function buscar($idOrden) {
        $cone = new Conexion();
        $c = $cone->conectando();
        $stmt = $c->prepare("SELECT * FROM ordeningrediente WHERE idOrden LIKE ?");
        $search = "%{$idOrden}%";
        $stmt->bind_param("s", $search);
        $stmt->execute();
        $res = $stmt->get_result();
        $datos = [];
        while ($row = $res->fetch_assoc()) {
            $datos[] = $row;
        }
        $stmt->close();
        return $datos;
    }

    public function listar() {
    $cone = new Conexion();
    $c = $cone->conectando();
    $sql2 = "SELECT sa.idOrden, 
                    sa.idIngrediente, 
                    sa.CantidadSolicitada, 
                    sa.idProveedor, 
                    sa.CantidadComprada, 
                    s.created_at
            FROM ordeningrediente sa
            INNER JOIN ordendecompra s ON sa.idOrden = s.idOrden
            ORDER BY sa.idOrden ASC";
    $ejecuta = mysqli_query($c, $sql2);
    $datos = [];
    while ($row = mysqli_fetch_assoc($ejecuta)) {
        $datos[] = $row;
    }
    return $datos;
}
}
?>