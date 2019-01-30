<?php
class Categoria {
    private $table = "categoria";
    private $conexion;

    private $id;
    private $nombre;

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

    public function getAll(){
        $consulta = $this->conexion->prepare("SELECT * FROM ".$this->table);
        $consulta->execute();
        $resultados = $consulta->fetchAll();

        $this->conexion = null;

        return $resultados;
    }

    public function getByID(){
        $consulta = $this->conexion->prepare("SELECT * FROM ".$this->table." WHERE idcategoria = :id");
        $res = $consulta->execute(array(
            "id" => $this->id
        ));
        $resultados = $consulta->fetch();

        $this->conexion = null;

        return $resultados;
    }

    public function save(){
        $consulta = $this->conexion->prepare("INSERT INTO ".$this->table." (nombre) VALUES (:nombre)");
        $save = $consulta->execute(array(
            "nombre" => $this->nombre
        ));
        $this->conexion = null;

        return $save;
    }

    public function delete(){
        $consulta = $this->conexion->prepare("DELETE FROM ".$this->table." WHERE idcategoria = :id");
        $del = $consulta->execute(array(
            "id" => $this->id
        ));
        $this->conexion = null;

        return $del;
    }

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