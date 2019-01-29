<?php
class PedidoHasProducto {
    private $table = "pedido_has_producto";
    private $conexion;

    private $idPedido;
    private $idProducto;
    private $cantidad;

    public function __construct($conexion, $idPedido=null, $idProducto=null, $cantidad=null) {
        $this->conexion = $conexion;
        if (isset($idPedido)){$this->idPedido = $idPedido;}
        if (isset($idProducto)){$this->idProducto = $idProducto;}
        if (isset($cantidad)){$this->cantidad = $cantidad;}
    }

    /**
     * @return mixed
     */
    public function getIdPedido()
    {
        return $this->idPedido;
    }

    /**
     * @param mixed $idPedido
     */
    public function setIdPedido($idPedido)
    {
        $this->idPedido = $idPedido;
    }

    /**
     * @return mixed
     */
    public function getIdProducto()
    {
        return $this->idProducto;
    }

    /**
     * @param mixed $idProducto
     */
    public function setIdProducto($idProducto)
    {
        $this->idProducto = $idProducto;
    }

    /**
     * @return mixed
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * @param mixed $cantidad
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;
    }

    public function getAll(){
        $consulta = $this->conexion->prepare("SELECT * FROM ".$this->table);
        $consulta->execute();
        $resultados = $consulta->fetchAll();

        $this->conexion = null;

        return $resultados;
    }

    public function getByIDs($idPedido, $idProducto){
        $consulta = $this->conexion->prepare("SELECT * FROM ".$this->table." WHERE idpedido = :idPedido AND idProducto = :idProducto");
        $res = $consulta->execute(array(
            "idPedido" => $idPedido,
            "idProducto" => $idProducto
        ));
        $resultados = $consulta->fetch();

        $this->conexion = null;

        return $resultados;
    }

    public function save($idPedido, $idProducto, $cantidad){
        $consulta = $this->conexion->prepare("INSERT INTO ".$this->table." (idPedido, idProducto, cantidad) VALUES (:idPedido, :idProducto, :cantidad)");
        $save = $consulta->execute(array(
            "idPedido" => $idPedido,
            "idProducto" => $idProducto,
            "cantidad" => $cantidad
        ));
        $this->conexion = null;

        return $save;
    }

    public function deleteByID($idPedido, $idProducto){
        $consulta = $this->conexion->prepare("DELETE FROM ".$this->table." WHERE idpedido = :idPedido AND idProducto = :idProducto");
        $del = $consulta->execute(array(
            "idPedido" => $idPedido,
            "idProducto" => $idProducto
        ));
        $this->conexion = null;

        return $del;
    }
}