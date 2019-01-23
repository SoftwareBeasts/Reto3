<?php
class Administrador {
    private $table = "admin";
    private $conexion;

    private $id;
    private $nombre;
    private $pass;

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
    public function getPass() {
        return $this->pass;
    }

    /**
     * @param mixed $pass
     */
    public function setPass($pass) {
        $this->pass = $pass;
    }

    public function getAll(){
        $consulta = $this->conexion->prepare("SELECT * FROM ".$this->table);
        $consulta->execute();
        $resultados = $consulta->fetchAll();

        $this->conexion = null;

        return $resultados;
    }

    public function getByNombre($nombre){
        $consulta = $this->conexion->prepare("SELECT * FROM ".$this->table." WHERE nombre = :nombre");
        $res = $consulta->execute(array(
            "nombre" => $nombre
        ));
        $resultado = $consulta->fetch();

        $this->conexion = null;

        return $resultado;
    }


    public function getByID($id){
        $consulta = $this->conexion->prepare("SELECT * FROM ".$this->table." WHERE idadmin = :id");
        $res = $consulta->execute(array(
            "id" => $id
        ));
        $resultados = $consulta->fetch();

        $this->conexion = null;

        return $resultados;
    }

    public function save(){
        $consulta = $this->conexion->prepare("INSERT INTO ".$this->table." (nombre, pass) VALUES (:nombre, :pass)");
        $save = $consulta->execute(array(
            "nombre" => $this->nombre,
            "pass" => $this->pass
        ));
        $this->conexion = null;

        return $save;
    }

    public function deleteByID($id){
        $consulta = $this->conexion->prepare("DELETE FROM ".$this->table." WHERE idadmin = :id");
        $del = $consulta->execute(array(
            "id" => $id
        ));
        $this->conexion = null;

        return $del;
    }
}