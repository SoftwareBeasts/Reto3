<?php
class Cliente {
    private $table = "cliente";
    private $conexion;

    private $id;
    private $nombre;
    private $email;
    private $telefono;

    /**
     * Cliente constructor. Los parametros son opcionales menos conexion
     * @param $conexion
     * @param null $id
     * @param null $nombre
     * @param null $email
     * @param null $telefono
     */
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

    /**
     * Devuelve todas las filas de la tabla Cliente de la BBDD
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
     * Devuelve la fila que coincida con el id del Objeto Cliente
     * @return mixed
     */
    public function getByID(){
        $consulta = $this->conexion->prepare("SELECT * FROM ".$this->table." WHERE idcliente = :id");
        $res = $consulta->execute(array(
            "id" => $this->id
        ));
        $resultados = $consulta->fetch();

        $this->conexion = null;

        return $resultados;
    }

    /**
     * Devuelve el id de la fila que coincida con el email del Objeto
     * @return mixed
     */
    public function getIdByEmail(){
        $consulta = $this->conexion->prepare("SELECT idCliente FROM ".$this->table." WHERE email = :emailE");
        $res = $consulta->execute(array(
            "emailE" => $this->email
        ));
        $resultados = $consulta->fetch();

        $this->conexion = null;

        return $resultados;
    }

    /**
     * Introduce un nuevo Cliente en la base de datos con los parametros del Objeto
     * @return mixed
     */
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

    /**
     * Elimina un Cliente de la base de datos mediante el id que tenga el Objeto
     * @return mixed
     */
    public function deleteByID(){
        $consulta = $this->conexion->prepare("DELETE FROM ".$this->table." WHERE idcliente = :id");
        $del = $consulta->execute(array(
            "id" => $this->id
        ));
        $this->conexion = null;

        return $del;
    }

    /**
     * Actualiza un Cliente de la base de datos con los datos del Objeto
     * @return mixed
     */
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