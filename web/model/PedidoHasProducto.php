<?php
class PedidoHasProducto {
    private $table = "pedido_has_producto";
    private $conexion;

    private $idPedido;
    private $idProducto;
    private $cantidad;

    /**
     * PedidoHasProducto constructor. Los aprametros son opcionales menos conexion
     * @param $conexion
     * @param null $idPedido
     * @param null $idProducto
     * @param null $cantidad
     */
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

    /**
     * Devuelve todas las filas de la tabla PedidoHasProducto de la base de datos
     * @return mixed
     */
    public function getAll(){
        $consulta = $this->conexion->prepare("SELECT * FROM ".$this->table);
        $consulta->execute();
        $resultados = $consulta->fetchAll();

        $this->conexion = null;

        return $resultados;
    }

    /**
     * Devuelve las filas que coincidan con el idPedido que tenga el Objeto
     * @return mixed
     */
    public function getByPedido(){
        $consulta = $this->conexion->prepare("SELECT * FROM ".$this->table." WHERE pedido_idpedido = :idPedido");
        $res = $consulta->execute(array(
            "idPedido" => $this->idPedido
        ));
        $resultados = $consulta->fetchAll();

        $this->conexion = null;

        return $resultados;
    }

    /**
     * Devuelve las filas que coincidan con los ids que tenga el Objeto
     * @return mixed
     */
    public function getByIDs(){
        $consulta = $this->conexion->prepare("SELECT * FROM ".$this->table." WHERE pedido_idpedido = :idPedido AND producto_idProducto = :idProducto");
        $res = $consulta->execute(array(
            "idPedido" => $this->idPedido,
            "idProducto" => $this->idProducto
        ));
        $resultados = $consulta->fetch();

        $this->conexion = null;

        return $resultados;
    }

    /**
     * Introduce un nuevo PedidoHasProducto a la base de datos con los parametros que tenga el objeto
     * @return mixed
     */
    public function save(){
        $consulta = $this->conexion->prepare("INSERT INTO ".$this->table." (pedido_idpedido, producto_idProducto, cantidad) VALUES (:idPedido, :idProducto, :cantidad)");
        $save = $consulta->execute(array(
            "idPedido" => $this->idPedido,
            "idProducto" => $this->idProducto,
            "cantidad" => $this->cantidad
        ));
        $this->conexion = null;

        return $save;
    }

    /**
     * Elimina una fila de la tabla PedidoHasProducto mediante el id que tenga el Objeto
     * @return mixed
     */
    public function deleteByID(){
        $consulta = $this->conexion->prepare("DELETE FROM ".$this->table." WHERE pedido_idpedido = :idPedido");
        $del = $consulta->execute(array(
            "idPedido" => $this->idPedido
        ));
        $this->conexion = null;

        return $del;
    }
}