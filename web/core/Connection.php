<?php

class Connection{
    private $driver;
    private $host, $user, $pass, $database, $charset;

    /**
     * Connection constructor.
     */
    public function __construct() {
        require_once __DIR__ . '/../config/database.php';
        $this->driver=DB_DRIVER;
        $this->host=DB_HOST;
        $this->user=DB_USER;
        $this->pass=DB_PASS;
        $this->database=DB_DATABASE;
        $this->charset=DB_CHARSET;
    }

    /**
     * Establece una conexion con la base de datos
     * @return PDO el objeto de la conexion
     * @throws Exception Si hay algun problema con la conexion
     */
    public function conexion(){

        $bbdd = $this->driver .':host='. $this->host .  ';dbname=' . $this->database . ';charset=' . $this->charset;

        //$bbdd = ' mysql:host=localhost;dbname=mvc1;charset=utf8';
        try {
            $connection = new PDO($bbdd, $this->user, $this->pass);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $connection;
        } catch (PDOException $e) {
            //Lanzamos la excepción
            throw new Exception('Problema al establecer conexión.');
        }
    }
}