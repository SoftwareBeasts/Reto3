<?php
class Administrador {
    private $table = "admin";
    private $conexion;

    private $id;
    private $nombre;
    private $pass;

    /**
     * Administrador constructor.Los atributos son opcionales menos conexion
     * @param $conexion La conexion a la base de datos
     * @param null $id id del administrador
     * @param null $nombre nombre del administrador
     * @param null $pass contraseña del administrador
     */
    public function __construct($conexion, $id=null, $nombre=null, $pass=null) {
        $this->conexion = $conexion;
        if (isset($id)){$this->id = $id;}
        if (isset($nombre)){$this->nombre = $nombre;}
        if (isset($pass)){$this->pass = $pass;}
//        $args = func_get_args();
//        foreach( $args as $arg ){
//            if ($arg ){
//
//            }
//        }
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

    /**
     * Devuelve todas las filas de la tabla admin de la BBDD
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
     * Devuelve las filas que coincidan con el nombre del Objeto Administrador
     * @return mixed
     */
    public function getByNombre(){
        $consulta = $this->conexion->prepare("SELECT * FROM ".$this->table." WHERE nombre = :nombre");
        $res = $consulta->execute(array(
            "nombre" => $this->nombre
        ));
        $resultado = $consulta->fetch();

        $this->conexion = null;

        return $resultado;
    }

    /**
     * Devuelve la fila que coincida con el id del Objeto Administrador
     * @return mixed
     */
    public function getByID(){
        $consulta = $this->conexion->prepare("SELECT * FROM ".$this->table." WHERE idadmin = :id");
        $res = $consulta->execute(array(
            "id" => $this->id
        ));
        $resultados = $consulta->fetch();

        $this->conexion = null;

        return $resultados;
    }

    /**
     * Introduce un administrador a la base de datos (No se usa en ningun lado)
     * @return mixed
     */
    public function save(){
        $consulta = $this->conexion->prepare("INSERT INTO ".$this->table." (nombre, pass) VALUES (:nombre, :pass)");
        $save = $consulta->execute(array(
            "nombre" => $this->nombre,
            "pass" => $this->pass
        ));
        $this->conexion = null;

        return $save;
    }

    /**
     * Elimina un administrador de la base de datos(No se usa en ningun lado)
     * @return mixed
     */
    public function deleteByID(){
        $consulta = $this->conexion->prepare("DELETE FROM ".$this->table." WHERE idadmin = :id");
        $del = $consulta->execute(array(
            "id" => $this->id
        ));
        $this->conexion = null;

        return $del;
    }
}