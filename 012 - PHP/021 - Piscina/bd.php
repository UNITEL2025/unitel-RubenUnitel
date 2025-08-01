<?php

class bd {
    //Parámetros de la BD
    public static $servername = "localhost";
    public static $username = "root";
    public static $password = "";
    public static $db = "piscina";

    
    //1) Comprobar que se puede realizar la conexión
    public static function check() : bool {
        if (self::get(false) instanceof PDO) return true;
        else return false;
    }
    //2) Crear la BD y las tablas si NO esta creada
    public static function init() {
        try {
            //Obtenemos el conector
            $conn = self::get(false);
            //Ejecutamos los sql
            $sql = "CREATE DATABASE IF NOT EXISTS ".self::$db;
            $conn->exec($sql);

            $conn = self::get();

            $sql = "CREATE TABLE IF NOT EXISTS empleados (
                id_empleado INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                nombre VARCHAR(30) NOT NULL,
                apellidos VARCHAR(30) NOT NULL,
                telefono VARCHAR(9),
                dni VARCHAR(10)
            )";
            $conn->exec($sql);

            $sql = "CREATE TABLE IF NOT EXISTS clientes (
                id_cliente INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                notas VARCHAR(500) DEFAULT '',
                fecha TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
            )";
            $conn->exec($sql);

            $sql = "CREATE TABLE IF NOT EXISTS asociados (
                id_asociado INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                nombre VARCHAR(30) NOT NULL,
                dni VARCHAR(10),
                notas VARCHAR(500) DEFAULT '',
                titular TINYINT(1) DEFAULT 0,
                fecha TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                cliente_id INT(10) UNSIGNED,
                CONSTRAINT fk_cliente_id
                    FOREIGN KEY (cliente_id)
                    REFERENCES ".self::$db.".clientes (id_cliente)
                    ON DELETE CASCADE
                    ON UPDATE NO ACTION
            )";
            $conn->exec($sql);

            $sql = "CREATE TABLE IF NOT EXISTS productos (
                id_producto INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                nombre VARCHAR(30) NOT NULL,
                precio DECIMAL(10,2) NOT NULL,
                notas VARCHAR(500) DEFAULT '',
                tipo TINYINT(1) DEFAULT 0,
                ref_ini INT(10) NOT NULL,
                fecha TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                fecha_ini TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                fecha_fin TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
            )";
            $conn->exec($sql);

            $sql = "CREATE TABLE IF NOT EXISTS ventas (
                id_venta INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                referencia INT(10) NOT NULL,
                fecha TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                cliente_id INT(10) UNSIGNED,
                CONSTRAINT fk2_cliente_id
                    FOREIGN KEY (cliente_id)
                    REFERENCES ".self::$db.".clientes (id_cliente)
                    ON DELETE SET NULL
                    ON UPDATE NO ACTION
            )";
            $conn->exec($sql);

            $sql = "CREATE TABLE IF NOT EXISTS ventas_detalle (
                id_venta_detalle INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                venta_id INT(10) UNSIGNED,
                producto_id INT(10) UNSIGNED,
                precio DECIMAL(10,2) NOT NULL,
                ctd INT(10) NOT NULL DEFAULT 0,
                CONSTRAINT fk_venta_id
                    FOREIGN KEY (venta_id)
                    REFERENCES ".self::$db.".ventas (id_venta)
                    ON DELETE CASCADE
                    ON UPDATE NO ACTION,
                CONSTRAINT fk_producto_id
                    FOREIGN KEY (producto_id)
                    REFERENCES ".self::$db.".productos (id_producto)
                    ON DELETE SET NULL
                    ON UPDATE NO ACTION
            )";
            $conn->exec($sql);

            return true;
        } catch(PDOException $e) {
            return "Error! Conexión fallida: " . $e->getMessage();
        }
    }

    //3) Obtener conector
    public static function get(bool $isBd = TRUE) {
        try {
            if ($isBd == TRUE) {
                $param_bd = "mysql:host=" .self::$servername .";dbname=" .self::$db;
            }
            else {
                $param_bd = "mysql:host=" .self::$servername;
            }
            $conn = new PDO($param_bd, self::$username, self::$password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch(PDOException $e) {
            return "Error! Conexión fallida: " . $e->getMessage();
        }
    }
}

bd::check();
bd::init();
?>