<?php
class Pedido {
    private $table = "pedido";
    private $conexion;

    private $id;
    private $fecha;
    private $estado;
    private $precioTotal;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getFecha() {
        return $this->fecha;
    }

    /**
     * @param mixed $fecha
     */
    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    /**
     * @return mixed
     */
    public function getEstado() {
        return $this->estado;
    }

    /**
     * @param mixed $estado
     */
    public function setEstado($estado) {
        $this->estado = $estado;
    }

    /**
     * @return mixed
     */
    public function getPrecioTotal() {
        return $this->precioTotal;
    }

    /**
     * @param mixed $precioTotal
     */
    public function setPrecioTotal($precioTotal) {
        $this->precioTotal = $precioTotal;
    }


}