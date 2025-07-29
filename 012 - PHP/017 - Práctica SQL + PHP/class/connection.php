<?php
class conn {
    //Definimos las variables de la conexión SQL
    public static $servername = "localhost";
    public static $username = "root";
    public static $password = "";
    public static $db = "crm";

    public static function init() : array {
        //Creamos la Base de Datos
        try {
            $conn = new PDO("mysql:host=".self::$servername, self::$username, self::$password); //Instanciamos conexión
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //Activamos avisos exception

            //Crear la BBDD
            $sql = "CREATE DATABASE IF NOT EXISTS crm";
            $conn->exec($sql);

            //Reconecto con la base de datos
            $conn = new PDO("mysql:host=".self::$servername.";dbname=".self::$db, self::$username, self::$password); //Instanciamos conexión
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //Activamos avisos exception

            //Creo la tabla        
            $sql = "CREATE TABLE IF NOT EXISTS customers (
                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                firstname VARCHAR(30) NOT NULL,
                lastname VARCHAR(30) NOT NULL,
                email VARCHAR(50),
                phone VARCHAR(50),
                notes VARCHAR(500),
                dateCreate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                dateUpdate TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )";
            $conn->exec($sql);
            $conn = null;

            return array(
                "status" => true,
                "msj" => ""
            );
        } catch(PDOException $e) {
            return array(
                "status" => false,
                "msj" => $e->getMessage()
            );
        }
    }

    public static function open() : array {
        try {
            $conn = new PDO("mysql:host=".self::$servername.";dbname=".self::$db, self::$username, self::$password); //Instanciamos conexión
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //Activamos avisos exception

            return array(
                "status" => true,
                "conn" => $conn
            );
        } catch(PDOException $e) {
            return array(
                "status" => false,
                "msj" => $e->getMessage()
            );
        }
    }
}

?>