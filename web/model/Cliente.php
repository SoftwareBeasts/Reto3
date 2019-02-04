<?php
class Cliente {
    private $table = "cliente";
    private $conexion;

    private $id;
    private $nombre;
    private $email;
    private $telefono;

    public function __construct($conexion, $id=null, $nombre=null, $email=null, $telefono=null) {
        $this->conexion = $conexion;
        if (isset($id)){$this->id = $id;}
        if (isset($nombre)){$this->nombre = $nombre;}
        if (isset($email)){$this->email = $email;}
        if (isset($telefono)){$this->telefono = $telefono;}
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
    public function getEmail() {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email) {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getTelefono() {
        return $this->telefono;
    }

    /**
     * @param mixed $telefono
     */
    public function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    public function getAll(){
        $consulta = $this->conexion->prepare("SELECT * FROM ".$this->table);
        $consulta->execute();
        $resultados = $consulta->fetchAll();

        $this->conexion = null;

        return $resultados;
    }

    public function getByID(){
        $consulta = $this->conexion->prepare("SELECT * FROM ".$this->table." WHERE idcliente = :id");
        $res = $consulta->execute(array(
            "id" => $this->id
        ));
        $resultados = $consulta->fetch();

        $this->conexion = null;

        return $resultados;
    }

    public function getIdByEmail(){
        $consulta = $this->conexion->prepare("SELECT idCliente FROM ".$this->table." WHERE email = :emailE");
        $res = $consulta->execute(array(
            "emailE" => $this->email
        ));
        $resultados = $consulta->fetch();

        $this->conexion = null;

        return $resultados;
    }

    public function save(){
        $consulta = $this->conexion->prepare("INSERT INTO ".$this->table." (nombre, email, telefono) VALUES (:nombre, :email, :telefono)");
        $save = $consulta->execute(array(
            "nombre" => $this->nombre,
            "email" => $this->email,
            "telefono" => $this->telefono
        ));
        //$this->conexion = null;

        return $save;
    }

    public function deleteByID(){
        $consulta = $this->conexion->prepare("DELETE FROM ".$this->table." WHERE idcliente = :id");
        $del = $consulta->execute(array(
            "id" => $this->id
        ));
        $this->conexion = null;

        return $del;
    }

    public function update(){
        $consulta = $this->conexion->prepare("UPDATE ".$this->table." SET nombre = :nombre, email = :email, telefono = :telefono WHERE idcliente = :id");
        $update = $consulta->execute(array(
            "nombre" => $this->nombre,
            "email" => $this->email,
            "telefono" => $this->telefono,
            "id" => $this->id
        ));

        $this->conexion = null;

        return $update;
    }
}