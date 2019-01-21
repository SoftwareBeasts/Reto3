<?php
class Cliente {
    private $table = "pedidoshosteleria";
    private $conexion;

    private $id;
    private $nombre;
    private $email;
    private $telefono;

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


}