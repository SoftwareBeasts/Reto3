<?php
class Producto {
    private $table = "pedidoshosteleria";
    private $conexion;

    private $id;
    private $nombre;
    private $descripcion;
    private $precio;
    private $rutaImg;
    private $pedidoMin;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param mixed $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * @return mixed
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * @param mixed $descripcion
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    /**
     * @return mixed
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * @param mixed $precio
     */
    public function setPrecio($precio)
    {
        $this->precio = $precio;
    }

    /**
     * @return mixed
     */
    public function getRutaImg()
    {
        return $this->rutaImg;
    }

    /**
     * @param mixed $rutaImg
     */
    public function setRutaImg($rutaImg)
    {
        $this->rutaImg = $rutaImg;
    }

    /**
     * @return mixed
     */
    public function getPedidoMin()
    {
        return $this->pedidoMin;
    }

    /**
     * @param mixed $pedidoMin
     */
    public function setPedidoMin($pedidoMin)
    {
        $this->pedidoMin = $pedidoMin;
    }


}