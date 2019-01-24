<?php
class Producto {
    private $table = "producto";
    private $conexion;

    private $id;
    private $nombre;
    private $descripcion;
    private $precio;
    private $rutaImg;
    private $pedidoMin;
    private $categoria;

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
    public function getNombre() {
        return $this->nombre;
    }

    /**
     * @param mixed $nombre
     */
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    /**
     * @return mixed
     */
    public function getDescripcion() {
        return $this->descripcion;
    }

    /**
     * @param mixed $descripcion
     */
    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    /**
     * @return mixed
     */
    public function getPrecio() {
        return $this->precio;
    }

    /**
     * @param mixed $precio
     */
    public function setPrecio($precio) {
        $this->precio = $precio;
    }

    /**
     * @return mixed
     */
    public function getRutaImg() {
        return $this->rutaImg;
    }

    /**
     * @param mixed $rutaImg
     */
    public function setRutaImg($rutaImg) {
        $this->rutaImg = $rutaImg;
    }

    /**
     * @return mixed
     */
    public function getPedidoMin() {
        return $this->pedidoMin;
    }

    /**
     * @param mixed $pedidoMin
     */
    public function setPedidoMin($pedidoMin) {
        $this->pedidoMin = $pedidoMin;
    }

    /**
     * @return mixed
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * @param mixed $categoria
     */
    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;
    }



    public function getAll(){
        $consulta = $this->conexion->prepare("SELECT * FROM ".$this->table . " ORDER BY categoria_idcategoria");
        $consulta->execute();
        $resultados = $consulta->fetchAll();

        $this->conexion = null;

        return $resultados;
    }

    public function getByID($id){
        $consulta = $this->conexion->prepare("SELECT * FROM ".$this->table." WHERE idproducto = :id");
        $res = $consulta->execute(array(
            "id" => $id
        ));
        $resultados = $consulta->fetch();

        $this->conexion = null;

        return $resultados;
    }

    public function getByIDs($ids){
        $stmnt = "SELECT * FROM ".$this->table." WHERE";
        $cont = 1;
        foreach ($ids as $id)
        {
            if($cont != 1)
                $stmnt .= " OR";
            $stmnt .= " idproducto = :id".$cont;
            $cont++;
        }
        $consulta = $this->conexion->prepare($stmnt);
        $res = $consulta->execute($ids);
        $resultados = $consulta->fetchAll();

        $this->conexion = null;

        return $resultados;
    }

    public function save(){
        $consulta = $this->conexion->prepare("INSERT INTO ".$this->table." (nombre, descripcion, precio, rutaImg, pedidoMin,categoria_idcategoria) VALUES (:nombre, :descripcion, :precio, :rutaImg, :pedidoMin, :categoria)");
        $save = $consulta->execute(array(
            "nombre" => $this->nombre,
            "descripcion" => $this->descripcion,
            "precio" => $this->precio,
            "rutaImg" => $this->rutaImg,
            "pedidoMin" => $this->pedidoMin,
            "categoria" =>$this->categoria
        ));
        $this->conexion = null;

        return $save;
    }

    public function deleteByID($id){
        $consulta = $this->conexion->prepare("DELETE FROM ".$this->table." WHERE idproducto = :id");
        $del = $consulta->execute(array(
            "id" => $id
        ));
        $this->conexion = null;

        return $del;
    }

    public function update(){
        $consulta = $this->conexion->prepare("UPDATE ".$this->table." SET nombre = :nombre, descripcion = :descripcion, precio = :precio, rutaImg = :rutaImg, pedidoMin = :pedidoMin , categoria_idcategoria = :categoria WHERE idproducto = :id");
        $update = $consulta->execute(array(
            "nombre" => $this->nombre,
            "descripcion" => $this->descripcion,
            "precio" => $this->precio,
            "rutaImg" => $this->rutaImg,
            "pedidoMin" => $this->pedidoMin,
            "categoria"=>$this->categoria,
            "id" => $this->id
        ));

        $this->conexion = null;

        return $update;
    }

    public function setAll($nombre,$desc,$precio,$rutaImg,$pedMin,$cat){
        $this->nombre=$nombre;
        $this->descripcion=$desc;
        $this->precio=$precio;
        $this->rutaImg=$rutaImg;
        $this->pedidoMin=$pedMin;
        $this->categoria=$cat;
    }
}