<?php
namespace Controlador;

use modelar\Proveedor;
use conectar\Conexion;

class ProveedorControlador
{
    public $model;

    public function __construct()
    {
        $this->model = new Proveedor();
    }
    public function guardar($data)
    {
        $this->model->idProveedor = $data['idProveedor'];
        $this->model->nombreProveedor = $data['NombreProveedor'];
        $this->model->numeroTelefono = $data['NumeroTelefono'];
        $this->model->direccion = $data['direccion'];
        $this->model->barrio = $data['Barrio'];
        $this->model->agregar();
    }

    public function modificar($data)
    {
        $this->model->idProveedor = $data['idProveedor'];
        $this->model->nombreProveedor = $data['NombreProveedor'];
        $this->model->numeroTelefono = $data['NumeroTelefono'];
        $this->model->direccion = $data['direccion'];
        $this->model->barrio = $data['Barrio'];
        $this->model->modificar();
    }

    public function eliminar($idProveedor)
    {
        $this->model->idProveedor = $idProveedor;
        $this->model->eliminar();
    }

    public function buscar($idProveedor, $desde = 0, $maximoRegistros = 6)
    {
        $cone = new Conexion();
        $c = $cone->conectando();
        $stmt = $c->prepare("SELECT * FROM proveedor WHERE idProveedor LIKE ? LIMIT ?, ?");
        $search = "%{$idProveedor}%";
        $stmt->bind_param("sii", $search, $desde, $maximoRegistros);
        $stmt->execute();
        $result = $stmt->get_result();
        $proveedores = [];
        while ($row = $result->fetch_assoc()) {
            $proveedores[] = $row;
        }
        $stmt->close();
        return $proveedores;
    }

    public function listar() {
    $cone = new Conexion();
    $c = $cone->conectando();
    $sql = "SELECT * FROM proveedor";
    $ejecuta = mysqli_query($c, $sql);
    $proveedores = [];
    while ($row = mysqli_fetch_assoc($ejecuta)) {
        $proveedores[] = $row; // Cada $row es un array asociativo
    }
    return $proveedores; // Devuelve un array de arrays
    }

    public function totalRegistros()
    {
        $cone = new Conexion();
        $c = $cone->conectando();
        $sql = "SELECT COUNT(*) as totalRegistro FROM proveedor";
        $res = mysqli_query($c, $sql);
        $fila = mysqli_fetch_assoc($res);
        return $fila['totalRegistro'];
    }
}
?>