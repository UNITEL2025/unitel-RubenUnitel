<?php
require "texto.php";

class bd {
    public static $servername = "localhost";
    public static $username = "root";
    public static $password = "";
    public static $db = "ejercicio_faq";

    

    public static function init() {
        global $faqs;
        
        try {
            $conn = new PDO("mysql:host=" .self::$servername, self::$username, self::$password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "CREATE DATABASE IF NOT EXISTS ejercicio_faq";
            $conn->exec($sql);
            echo "PDO: Conectado satisfactoriamente";
        } catch(PDOException $e) {
            echo "<br>Conexión fallida: " . $e->getMessage();
        }

        try {
            $conn = new PDO("mysql:host=" .self::$servername .";dbname=" .self::$db, self::$username, self::$password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "<br>PDO: Conectado satisfactoriamente";
        } catch(PDOException $e) {
            echo "<br>Conexión fallida: " . $e->getMessage();
        }

        try {
            $sql = "CREATE TABLE IF NOT EXISTS tbFaq (
                id_faq INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                titulo VARCHAR(30) NOT NULL,
                texto VARCHAR(255) NOT NULL,
                contador INT(6) DEFAULT 0
            )";
            $conn->exec($sql);
            echo "<br>La tabla se ha creado satisfactoriamente";
        } catch (PDOException $e) {
            echo "<br>" .$sql . "<br>" . $e->getMessage();
        }

        try {
            $stmt = $conn->prepare("INSERT INTO tbFaq (titulo, texto)
            VALUES (:titulo, :texto)");
            $stmt->bindParam(':titulo', $titulo);
            $stmt->bindParam(':texto', $texto);

            foreach ($faqs as $faq) {
                $titulo = $faq["titulo"];
                $texto = $faq["texto"];
                $stmt->execute();
            }

            echo "<br>New records created successfully";
        } catch(PDOException $e) {
            echo "<br>Error: " . $e->getMessage();
        }
    }

    public static function getConn() {
        try {
            $conn = new PDO("mysql:host=" .self::$servername .";dbname=" .self::$db, self::$username, self::$password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch(PDOException $e) {
            return null;
        }
    }
}

//bd::init();

?>