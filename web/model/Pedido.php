<?php
class Pedido {
    private $table = "pedido";
    private $conexion;

    private $id;
    private $fecha;
    private $estado;
    private $precioTotal;
    private $idCliente;

    public function __construct($conexion, $id=null, $fecha=null, $estado=null, $precioTotal=null, $idCliente=null) {
        $this->conexion = $conexion;
        if (isset($id)){$this->id = $id;}
        if (isset($fecha)){$this->fecha = $fecha;}
        if (isset($estado)){$this->estado = $estado;}
        if (isset($precioTotal)){$this->precioTotal = $precioTotal;}
        if (isset($idCliente)){$this->idCliente = $idCliente;}
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

    /**
     * @return mixed
     */
    public function getIdCliente()
    {
        return $this->idCliente;
    }

    /**
     * @param mixed $idCliente
     */
    public function setIdCliente($idCliente)
    {
        $this->idCliente = $idCliente;
    }

    public function getAll(){
        $consulta = $this->conexion->prepare("SELECT * FROM ".$this->table);
        $consulta->execute();
        $resultados = $consulta->fetchAll();

        $this->conexion = null;

        return $resultados;
    }

    public function getByID(){
        $consulta = $this->conexion->prepare("SELECT * FROM ".$this->table." WHERE idpedido = :id");
        $res = $consulta->execute(array(
            "id" => $this->id
        ));
        $resultados = $consulta->fetch();

        $this->conexion = null;

        return $resultados;
    }

    public function getIdByClienteId(){
        $consulta = $this->conexion->prepare("SELECT idPedido FROM ".$this->table." WHERE cliente_idcliente = :idCliente");
        $res = $consulta->execute(array(
            "idCliente" => $this->idCliente
        ));
        $resultados = $consulta->fetch();
        $this->id = $resultados['idPedido'];
        //$this->conexion = null;

        return $resultados;
    }

    public function save(){
        $consulta = $this->conexion->prepare("INSERT INTO ".$this->table." (fecha, estado, precioTotal, cliente_idcliente) VALUES (:fecha, :estado, :precioTotal, :clienteId)");
        $save = $consulta->execute(array(
            "fecha" => $this->fecha,
            "estado" => $this->estado,
            "precioTotal" => $this->precioTotal,
            "clienteId" => $this->idCliente
        ));
        //$this->conexion = null;

        return $save;
    }

    public function savePrecioTotal(){
        $consulta = $this->conexion->prepare("UPDATE ".$this->table." SET precioTotal = :precioTotal WHERE idPedido = :idPedido");
        $save = $consulta->execute(array(
            "precioTotal" => $this->precioTotal,
            "idPedido" => $this->id,
        ));
        $this->conexion = null;

        return $save;
    }

    public function deleteByID(){
        $consulta = $this->conexion->prepare("DELETE FROM ".$this->table." WHERE idpedido = :id");
        $del = $consulta->execute(array(
            "id" => $this->id
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

    public function updateEstado()
    {
        $consulta = $this->conexion->prepare("UPDATE ".$this->table." SET estado = :estado WHERE idpedido = :id");
        $update = $consulta->execute(array(
            "id" => $this->id,
            "estado" => $this->estado
        ));

        $this->conexion = null;
    }
}