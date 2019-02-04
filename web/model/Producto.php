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
    private $vecesComprado;

    /**
     * Producto constructor. Los parametros son opcionales menos conexion
     * @param $conexion
     * @param null $id
     * @param null $nombre
     * @param null $descripcion
     * @param null $precio
     * @param null $rutaImg
     * @param null $pedidoMin
     * @param null $categoria
     * @param null $vecesComprado
     */
    public function __construct($conexion, $id=null, $nombre=null, $descripcion=null, $precio=null, $rutaImg=null, $pedidoMin=null, $categoria=null, $vecesComprado=null) {
        $this->conexion = $conexion;
        if (isset($id)){$this->id = $id;}
        if (isset($nombre)){$this->nombre = $nombre;}
        if (isset($descripcion)){$this->descripcion = $descripcion;}
        if (isset($precio)){$this->precio = $precio;}
        if (isset($rutaImg)){$this->rutaImg = $rutaImg;}
        if (isset($pedidoMin)){$this->pedidoMin = $pedidoMin;}
        if (isset($categoria)){$this->categoria = $categoria;}
        if (isset($vecesComprado)){$this->vecesComprado = $vecesComprado;}
    }

    /**
     * @return null
     */
    public function getVecesComprado()
    {
        return $this->vecesComprado;
    }

    /**
     * @param null $vecesComprado
     */
    public function setVecesComprado($vecesComprado)
    {
        $this->vecesComprado = $vecesComprado;
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


    /**
     * Devuelve todas las filas de la tabla Producto de la BBDD ordenadas por categoria
     * @return mixed
     */
    public function getAll(){
        $consulta = $this->conexion->prepare("SELECT * FROM ".$this->table . " ORDER BY categoria_idcategoria");
        $consulta->execute();
        $resultados = $consulta->fetchAll();

        $this->conexion = null;

        return $resultados;
    }

    /**
     * Devuelve el nombre y las veces que se ha comprado cada producto ordenado por  las veces que se ha comprado
     * @return mixed
     */
    public function getAllStats(){
        $consulta = $this->conexion->prepare("SELECT nombre, vecesComprado FROM ".$this->table . " ORDER BY vecesComprado DESC");
        $consulta->execute();
        $resultados = $consulta->fetchAll();

        $this->conexion = null;

        return $resultados;
    }

    /**
     * Devuelve una fila mediante la id del Objeto
     * @return mixed
     */
    public function getByID(){
        $consulta = $this->conexion->prepare("SELECT * FROM ".$this->table." WHERE idproducto = :id");
        $res = $consulta->execute(array(
            "id" => $this->id
        ));
        $resultados = $consulta->fetch();

        $this->conexion = null;

        return $resultados;
    }

    /**
     * Devuelve el precio y las veces que se ha comprado la fila que tenga el mismo id que el Objeto
     * @return mixed
     */
    public function getPrecioAndVecesCompradoByID(){
        $consulta = $this->conexion->prepare("SELECT precio, vecesComprado FROM ".$this->table." WHERE idproducto = :id");
        $res = $consulta->execute(array(
            "id" => $this->id
        ));
        $resultados = $consulta->fetch();

        return $resultados;
    }

    /**
     * Actualiza el parametro veces comprado de una fila mediante el id del Objeto
     * @return mixed
     */
    public function saveVecesComprado(){
        $consulta = $this->conexion->prepare("UPDATE ".$this->table." SET vecesComprado = :vecesComprado WHERE idProducto = :idProducto");
        $save = $consulta->execute(array(
            "vecesComprado" => $this->vecesComprado,
            "idProducto" => $this->id,
        ));
        $this->conexion = null;

        return $save;
    }

    /**
     * Devuelve filas de la tabla Producto en funcion del los id que se pasen por el array
     * @param $ids los ids que se quieren devolver
     * @return mixed
     */
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

    /**
     * Introduce un nuevo producto en la base de datos mediante los datos que tenga el Objeto
     * @return mixed
     */
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

    /**
     * Elimina una fila de la tabla Producto mediante el id del Objeto
     * @return mixed
     */
    public function delete(){
        $consulta = $this->conexion->prepare("DELETE FROM ".$this->table." WHERE idproducto = :id");
        $del = $consulta->execute(array(
            "id" => $this->id
        ));
        $this->conexion = null;

        return $del;
    }

    /**
     * Elimina una fila de la tabla Productos mediante el id del Objeto
     * @return mixed
     */
    public function deleteByID(){
        $consulta = $this->conexion->prepare("DELETE FROM ".$this->table." WHERE idproducto = :id");
        $del = $consulta->execute(array(
            "id" => $this->id
        ));
        $this->conexion = null;

        return $del;
    }

    /**
     * Actualiza una fila de la tabla Productos mediante los datos que tenga el Objeto
     * @return mixed
     */
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

    /**
     * Metodo para introducir todos los parametros del Objeto de golpe
     * @param $nombre
     * @param $desc
     * @param $precio
     * @param $rutaImg
     * @param $pedMin
     * @param $cat
     */
    public function setAll($nombre,$desc,$precio,$rutaImg,$pedMin,$cat){
        $this->nombre=$nombre;
        $this->descripcion=$desc;
        $this->precio=$precio;
        $this->rutaImg=$rutaImg;
        $this->pedidoMin=$pedMin;
        $this->categoria=$cat;
    }
}