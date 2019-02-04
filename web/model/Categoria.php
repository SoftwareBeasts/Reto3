<?php
class Categoria {
    private $table = "categoria";
    private $conexion;

    private $id;
    private $nombre;

    /**
     * Categoria constructor. Los parametros son opcionales menos conexiom
     * @param $conexion
     * @param null $id
     * @param null $nombre
     */
    public function __construct($conexion, $id=null, $nombre=null) {
        $this->conexion = $conexion;
        if (isset($id)){$this->id = $id;}
        if (isset($nombre)){$this->nombre = $nombre;}
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
     * Devuelve todas las filas de la tabla Categoria de la BBDD
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
     * Devuelve la fila que coincida con el id del Objeto Categoria
     * @return mixed
     */
    public function getByID(){
        $consulta = $this->conexion->prepare("SELECT * FROM ".$this->table." WHERE idcategoria = :id");
        $res = $consulta->execute(array(
            "id" => $this->id
        ));
        $resultados = $consulta->fetch();

        $this->conexion = null;

        return $resultados;
    }

    /**
     * Introduce una nueva Categoria en la base de datos con los parametros que tenga el Objeto
     * @return mixed
     */
    public function save(){
        $consulta = $this->conexion->prepare("INSERT INTO ".$this->table." (nombre) VALUES (:nombre)");
        $save = $consulta->execute(array(
            "nombre" => $this->nombre
        ));
        $this->conexion = null;

        return $save;
    }

    /**
     * Elimina una Categoria de la base de datos mediante el id que tenga el Objeto
     * @return mixed
     */
    public function delete(){
        $consulta = $this->conexion->prepare("DELETE FROM ".$this->table." WHERE idcategoria = :id");
        $del = $consulta->execute(array(
            "id" => $this->id
        ));
        $this->conexion = null;

        return $del;
    }

    /**
     * Actualiza una fila de la tabla Categorias mediante los datos que tenga el Objeto
     * @return mixed
     */
    public function update(){
        $consulta = $this->conexion->prepare("UPDATE ".$this->table." SET nombre = :nombre WHERE idcategoria = :id");
        $update = $consulta->execute(array(
            "nombre" => $this->nombre,
            "id" => $this->id
        ));

        $this->conexion = null;

        return $update;
    }
}