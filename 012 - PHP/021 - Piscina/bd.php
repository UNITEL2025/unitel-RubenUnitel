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
                asociado_id INT(10) UNSIGNED,
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
                fecha TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                cliente_id INT(10) UNSIGNED,
                empleado_id INT(10) UNSIGNED,
                metodo_pago VARCHAR(25),
                CONSTRAINT fk2_cliente_id
                    FOREIGN KEY (cliente_id)
                    REFERENCES ".self::$db.".clientes (id_cliente)
                    ON DELETE SET NULL
                    ON UPDATE NO ACTION,
                CONSTRAINT fk2_empleado_id
                    FOREIGN KEY (empleado_id)
                    REFERENCES ".self::$db.".empleados (id_empleado)
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

            $sql = "CREATE TABLE IF NOT EXISTS detalle_ref (
                id_detalle_ref INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                detalle_id INT(10) UNSIGNED NOT NULL,
                referencia INT(10) NOT NULL,
                CONSTRAINT fk1_detalle_id
                    FOREIGN KEY (detalle_id)
                    REFERENCES ".self::$db.".ventas_detalle (id_venta_detalle)
                    ON DELETE CASCADE
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

    public static function getAll(string $table) {
        $sql = 'SELECT * FROM '.$table;

        $conn = bd::get();
        if ($conn instanceof PDO) {
            $stmt = $conn->prepare($sql); 
            $stmt->execute();
            return $stmt->fetchAll();
        }
        else {
            return null;
        }
    }

    public static function getById(string $table, int $id) {
        $id_tipo = "";
        switch ($table) {
            case 'asociados':
                $id_tipo = "id_asociado";
                break;
            
            case 'clientes':
                $id_tipo = "id_cliente";
                break;

            case 'detalle_ref':
                $id_tipo = "id_detalle_ref";
                break;
            
            case 'empleados':
                $id_tipo = "id_empleado";
                break;

            case 'productos':
                $id_tipo = "id_producto";
                break;

            case 'ventas_detalle':
                $id_tipo = "id_venta_detalle";
                break;
        }
        $sql = 'SELECT * FROM '.$table.' WHERE '.$id_tipo.' = :id';

        $conn = bd::get();
        if ($conn instanceof PDO) {
            $stmt = $conn->prepare($sql); 
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetchAll();
        }
        else {
            return null;
        }
    }

    public static function deleteById(string $table, int $id) : bool {
        $sql = 'DELETE FROM '.$table.' WHERE id = :id';

        $conn = bd::get();
        if ($conn instanceof PDO) {
            $stmt = $conn->prepare($sql); 
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        }
        else {
            return null;
        }
    }

    public static function deleteAll(string $table) {
        $sql = 'DELETE FROM '.$table;

        $conn = bd::get();
        if ($conn instanceof PDO) {
            $stmt = $conn->prepare($sql); 
            return $stmt->execute();
        }
        else {
            return null;
        }
    }

    public static function getTablas() {
        $sql = 'SELECT table_name
                FROM information_schema.tables
                WHERE table_type="BASE TABLE" AND table_schema = "'.self::$db.'"';

        $conn = bd::get();
        if ($conn instanceof PDO) {
            $stmt = $conn->prepare($sql); 
            $stmt->execute();
            $items = $stmt->fetchAll();

            $salida = array();
            foreach ($items as $item) {
                $salida[] = $item["table_name"];
            }
            return $salida;
        }
        else {
            return null;
        }
    }
}

bd::check();
//bd::init();
?>