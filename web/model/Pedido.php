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

    public function getAll(){
        $consulta = $this->conexion->prepare("SELECT * FROM ".$this->table);
        $consulta->execute();
        $resultados = $consulta->fetchAll();

        $this->conexion = null;

        return $resultados;
    }

    public function getByID($id){
        $consulta = $this->conexion->prepare("SELECT * FROM ".$this->table." WHERE idpedido = :id");
        $res = $consulta->execute(array(
            "id" => $id
        ));
        $resultados = $consulta->fetch();

        $this->conexion = null;

        return $resultados;
    }

    public function save(){
        $consulta = $this->conexion->prepare("INSERT INTO ".$this->table." (fecha, estado, precioTotal) VALUES (:fecha, :estado, :precioTotal)");
        $save = $consulta->execute(array(
            "fecha" => $this->fecha,
            "estado" => $this->estado,
            "precioTotal" => $this->precioTotal
        ));
        $this->conexion = null;

        return $save;
    }

    public function deleteByID($id){
        $consulta = $this->conexion->prepare("DELETE FROM ".$this->table." WHERE idpedido = :id");
        $del = $consulta->execute(array(
            "id" => $id
        ));
        $this->conexion = null;

        return $del;
    }

    public function update(){
        $consulta = $this->conexion->prepare("UPDATE ".$this->table." SET fecha = :fecha, estado = :estado, precioTotal = :precioTotal WHERE idpedido = :id");
        $update = $consulta->execute(array(
            "fecha" => $this->fecha,
            "estado" => $this->estado,
            "precioTotal" => $this->precioTotal,
            "id" => $this->id
        ));

        $this->conexion = null;

        return $update;
    }

    public function updateEstado($id, $estado)
    {
        $consulta = $this->conexion->prepare("UPDATE ".$this->table." SET estado = :estado WHERE idpedido = :id");
        $update = $consulta->execute(array(
            "id" => $id,
            "estado" => $estado
        ));

        $this->conexion = null;
    }
}